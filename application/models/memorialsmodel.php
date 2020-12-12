<?php


namespace Framework\models;


use Framework\lib\AbstractModel;

class MemorialsModel extends AbstractModel
{
    public $id;
    public $firstName;
    public $lastName;
    public $nickName;
    public $gender;
    public $relationship;
    public $relationship_other;
    public $birthDate;
    public $birthCountry;
    public $birthState;
    public $passingDate;
    public $passingCountry;
    public $passingState;
    public $webAddress;
    public $epithet;
    public $views;
    public $createdBy;
    public $created;

    protected static $tableName = 'memorials';
    protected static $primaryKey = 'id';
    protected static $tableSchema = array(
        'firstName' => self::DATA_TYPE_STR,
        'lastName' => self::DATA_TYPE_STR,
        'nickName' => self::DATA_TYPE_STR,
        'gender' => self::DATA_TYPE_STR,
        'relationship' => self::DATA_TYPE_STR,
        'relationship_other' => self::DATA_TYPE_STR,
        'birthDate' => self::DATA_TYPE_STR,
        'birthCountry' => self::DATA_TYPE_STR,
        'birthState' => self::DATA_TYPE_STR,
        'passingDate' => self::DATA_TYPE_STR,
        'passingCountry' => self::DATA_TYPE_STR,
        'passingState' => self::DATA_TYPE_STR,
        'webAddress' => self::DATA_TYPE_STR,
        'epithet' => self::DATA_TYPE_STR,
        'views' => self::DATA_TYPE_INT,
        'createdBy' => self::DATA_TYPE_INT,
        'created' => self::DATA_TYPE_STR
    );

    public static function GetMemorialDetails($options = '')
    {
        $sql = "SELECT memorials.*, users.firstName AS author_firstName, users.lastName AS author_lastName
                FROM memorials 
                LEFT JOIN users ON memorials.createdBy = users.id
                $options";
        return parent::GetSQL($sql, '', true);
    }

    public static function GetMemorialsWithPhoto($options = '')
    {
        $sql = "SELECT memorials.*, 
                    (SELECT memorial_photos.name 
                     FROM memorial_photos 
                     WHERE memorial_photos.memorial_id = memorials.id
                     ORDER BY memorial_photos.feature, memorial_photos.updated DESC LIMIT 1
                     ) AS photo
                FROM memorials
                $options";
        return parent::GetSQL($sql);
    }

    public static function GetMemorialViews($id)
    {
        $sql = "SELECT views FROM memorials WHERE id = '$id'";
        return parent::GetSQL($sql, '', true);
    }

    public static function GetVisitedMemorials($user_id)
    {
        $sql = "SELECT memorials.*, 
                    memorial_visits.user_id, memorial_visits.visits,
                    (SELECT memorial_photos.name 
                     FROM memorial_photos 
                     WHERE memorial_photos.memorial_id = memorials.id
                     ORDER BY memorial_photos.feature, memorial_photos.updated DESC LIMIT 1
                     ) AS photo
                FROM memorials
                INNER JOIN memorial_visits ON memorials.id = memorial_visits.memorial_id
                WHERE memorial_visits.user_id = :user_id && memorials.createdBy != :user_id
                GROUP BY memorials.id";
        return parent::GetSQL($sql, array('user_id' => array(parent::DATA_TYPE_INT, $user_id)));
    }

    public static function Search($keyword, $options = '')
    {
        $sql = "SELECT memorials.*, 
                    (SELECT memorial_photos.name 
                     FROM memorial_photos 
                     WHERE memorial_photos.memorial_id = memorials.id
                     ORDER BY memorial_photos.feature, memorial_photos.updated DESC LIMIT 1
                     ) AS photo
                FROM memorials
                WHERE (
                  memorials.firstName LIKE '%$keyword%' || 
                  memorials.lastName LIKE '%$keyword%' ||
                  memorials.nickName LIKE '%$keyword%' ||
                  memorials.webAddress LIKE '%$keyword%' ||
                  memorials.epithet LIKE '%$keyword%'
                ) 
                $options ";
        return parent::GetSQL($sql);
    }
}