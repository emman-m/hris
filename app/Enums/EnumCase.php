<?php

namespace App\Enums;

class EnumCase
{
    public static function list()
    {
        $list = [];
        foreach (self::cases() as $case) {
            array_push($list, $case->name);
        }

        return $list;
    }
}