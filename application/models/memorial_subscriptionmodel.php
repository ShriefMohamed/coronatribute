<?php


namespace Framework\models;


use Framework\lib\AbstractModel;

class Memorial_subscriptionModel extends AbstractModel
{
    public $id;

    protected static $tableName = 'memorials';
    protected static $primaryKey = 'id';
    protected static $tableSchema = array(

    );
}