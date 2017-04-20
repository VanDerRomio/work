<?php

/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 04.11.2016
 * Time: 19:18
 */
class functionDB
{
    public static function getValue($key)
    {
        $db = DB::getConnection();
        //запит до БД
        $result = $db->prepare('SELECT _value '
            .'FROM settings '
            .'WHERE _key=? '
            .'LIMIT 1');
        $result->setFetchMode(PDO::FETCH_ASSOC);

        if($result->execute(array($key,)))
        {
            $value = $result->fetch();
            return $value['_value'];
        }
        else
        {
            return false;
        }
    }
    
    public static function setValue($key, $value)
    {
        //запит до БД
        $resultUpdate = $db->prepare('UPDATE settings SET value=:value WHERE key=:key');

        $resultUpdate->execute(array(
            'value'=>$value,
            'key'=>$key,));

        if($resultUpdate)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}