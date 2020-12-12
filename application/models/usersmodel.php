<?php

namespace Framework\models;


use Framework\lib\AbstractModel;

class UsersModel extends AbstractModel
{
    public $id;
    public $api;
    public $api_userID;
    public $firstName;
    public $lastName;
    public $username;
    public $email;
    public $password;
    public $phone;
    public $role;
    public $created;
    public $lastUpdate;
    public $lastSeen;
    public $imageType;
    public $image;
    public $status;
    public $forgotPasswordToken;
    public $forgotPasswordToken_time;

    protected static $tableName = 'users';
    protected static $primaryKey = 'id';
    protected static $tableSchema = array(
        'api' => self::DATA_TYPE_STR,
        'api_userID' => self::DATA_TYPE_STR,
        'firstName' => self::DATA_TYPE_STR,
        'lastName' => self::DATA_TYPE_STR,
        'username' => self::DATA_TYPE_STR,
        'email' => self::DATA_TYPE_STR,
        'password' => self::DATA_TYPE_STR,
        'phone' => self::DATA_TYPE_INT,
        'role' => self::DATA_TYPE_STR,
        'created' => self::DATA_TYPE_STR,
        'lastUpdate' => self::DATA_TYPE_STR,
        'lastSeen' => self::DATA_TYPE_STR,
        'imageType' => self::DATA_TYPE_INT,
        'image' => self::DATA_TYPE_STR,
        'status' => self::DATA_TYPE_STR,
        'forgotPasswordToken' => self::DATA_TYPE_STR,
        'forgotPasswordToken_time' => self::DATA_TYPE_STR
    );

    public static function Authenticate($username, $password)
    {
        $sql = "SELECT users.*
                FROM " . static::$tableName . " 
                WHERE (users.username = :username OR users.email = :email OR users.phone = :phone) 
                    AND users.password = :password";
        return parent::GetSQL($sql, array(
                'username' => array(parent::DATA_TYPE_STR, $username),
                'email' => array(parent::DATA_TYPE_STR, $username),
                'phone' => array(parent::DATA_TYPE_INT, $username),
                'password' => array(parent::DATA_TYPE_STR, $password)
            ), true);
    }
}