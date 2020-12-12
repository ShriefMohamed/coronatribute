<?php


namespace Framework\models;


use Framework\lib\AbstractModel;

class Memorial_photosModel extends AbstractModel
{
    public $id;
    public $memorial_id;
    public $name;
    public $feature;
    public $createdBy;
    public $created;
    public $updated;

    protected static $tableName = 'memorial_photos';
    protected static $primaryKey = 'id';
    protected static $tableSchema = array(
        'memorial_id' => self::DATA_TYPE_INT,
        'name' => self::DATA_TYPE_STR,
        'feature' => self::DATA_TYPE_INT,
        'createdBy' => self::DATA_TYPE_INT,
        'created' => self::DATA_TYPE_STR,
        'updated' => self::DATA_TYPE_STR
    );

    public static function GetPhotos($options)
    {
        $sql = "SELECT memorial_photos.*, 
                    users.firstName, users.lastName
                FROM memorial_photos 
                LEFT JOIN users ON memorial_photos.createdBy = users.id
                $options";
        return parent::GetSQL($sql);
    }
}