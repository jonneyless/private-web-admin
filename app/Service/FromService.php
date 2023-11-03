<?php

namespace App\Service;

use App\Models\From;

class FromService
{
    public static function one($condition = [])
    {
        $query = From::query();

        if (is_right_data($condition, "id")) {
            $query->where("id", $condition["id"]);
        }
        if (is_right_data($condition, "user_tg_id")) {
            $query->where("user_tg_id", $condition["user_tg_id"]);
        }

        return $query->first();
    }
}