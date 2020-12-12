<?php

namespace Framework\lib;


trait FilterInput
{
    private static function Check($value)
    {
        return empty($value) ? false : $value;
    }

    public static function Int($value)
    {
        return is_int(self::Check(intval($value))) ? filter_var($value, FILTER_SANITIZE_NUMBER_INT) : null;
    }

    public static function String($value)
    {
        return is_string(self::Check($value)) ? filter_var($value, FILTER_SANITIZE_STRING) : null;
    }

    public static function Email($value)
    {
        return self::Check($value) ? filter_var($value, FILTER_SANITIZE_EMAIL) : null;
    }

    public static function FilterDateTime($value, $type = 'date_time')
    {
        if (self::CheckValue($value)) {
            if ($type == 'date') {
                if ($date = \DateTime::createFromFormat(DATE_FORMAT, $value)) {
                    return $date->format(DATE_FORMAT);
                } else {
                    return false;
                }
            } elseif ($type == 'time') {
                if ($time = \DateTime::createFromFormat(TIME_FORMAT, $value)) {
                    return $time->format(TIME_FORMAT);
                } else {
                    return false;
                }
            } elseif ($type == 'date_time') {
                if ($date_time = \DateTime::createFromFormat(DATE_TIME_FORMAT, $value)) {
                    return $date_time->format(DATE_TIME_FORMAT);
                } else {
                    return false;
                }
            }
        }
    }

    public static function DecodeParam($value)
    {
        return self::CheckValue($value) ? urldecode($value) : false;
    }
}