<?php

namespace App\Traits;

trait Listable
{
    public static function list(): array
    {
        $list = [];
        foreach (static::cases() as $case) {
            $list[] = $case->value;
        }

        return $list;
    }
}