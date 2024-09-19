<?php

namespace App\Models;

class Business extends BaseModel
{
    protected $table = "business";

    public static function getSelectData()
    {
        return self::query()->where('status', 1)->orderBy('orderr')->pluck('name', 'id')->toArray();
    }
}