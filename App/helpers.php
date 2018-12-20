<?php

namespace App;

class Helpers{
    public static function inputFormat($input)
    {
        $result = [];

        foreach ($input as $key => &$value) {
            $result[$key] = htmlspecialchars(stripcslashes(trim($value)));
        }

        return $result;
    }

    public static function optionToQuery($option){
        $keys = implode(',', array_keys($option));
        $valueKeys = [];
        foreach (array_keys($option) as $k){
            $valueKeys[] = ":".$k;
        }
        $values = implode(', ', array_values($valueKeys));

        return [
            $keys,
            $values
        ];
    }

    public static function optionToUpdate($option){
        $sorgu = [];
        foreach ($option as $key => $value){
            $sorgu[] = $key . "=:".$key;
        }

        return implode(', ', $sorgu);
    }

    public static function urlEncode($s){
        $s = preg_replace('ö','oe', $s);
    }
}