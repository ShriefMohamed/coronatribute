<?php


namespace Framework\models;


use Framework\lib\AbstractModel;

class Memorial_tributesModel extends AbstractModel
{
    public $id;
    public $memorial_id;
    public $tribute;
    public $createdBy;
    public $created;

    protected static $tableName = 'memorial_tributes';
    protected static $primaryKey = 'id';
    protected static $tableSchema = array(
        'memorial_id' => self::DATA_TYPE_INT,
        'tribute' => self::DATA_TYPE_STR,
        'createdBy' => self::DATA_TYPE_INT
    );

    public static function GetAllTributes($options = '')
    {
        $sql = "SELECT memorial_tributes.*,
                    memorials.webAddress,
                    users.firstName, users.lastName, users.imageType, users.image
                FROM memorial_tributes
                LEFT JOIN users ON memorial_tributes.createdBy = users.id
                LEFT JOIN memorials ON memorial_tributes.memorial_id = memorials.id
                $options";
        return parent::GetSQL($sql);
    }
}