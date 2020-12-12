<?php


namespace Framework\models;


use Framework\lib\AbstractModel;

class Memorial_storiesModel extends AbstractModel
{
    public $id;
    public $memorial_id;
    public $story;
    public $createdBy;
    public $created;

    protected static $tableName = 'memorial_stories';
    protected static $primaryKey = 'id';
    protected static $tableSchema = array(
        'memorial_id' => self::DATA_TYPE_INT,
        'story' => self::DATA_TYPE_STR,
        'createdBy' => self::DATA_TYPE_INT
    );
}