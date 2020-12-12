<?php


namespace Framework\models;


use Framework\lib\AbstractModel;

class Memorial_visitsModel extends AbstractModel
{
    public $id;
    public $memorial_id;
    public $user_id;
    public $created;
    public $lastVisit;
    public $visits;

    protected static $tableName = 'memorial_visits';
    protected static $primaryKey = 'id';
    protected static $tableSchema = array(
        'memorial_id' => self::DATA_TYPE_INT,
        'user_id' => self::DATA_TYPE_INT,
        'created' => self::DATA_TYPE_STR,
        'lastVisit' => self::DATA_TYPE_STR,
        'visits' => self::DATA_TYPE_INT
    );
}