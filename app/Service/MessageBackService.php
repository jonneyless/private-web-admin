<?php

namespace App\Service;

use App\Models\MessageBack as Message;

class MessageBackService
{
    public static function gets($condition = [])
    {
        $query = Message::query();

        if (is_right_data($condition, "from_tg_id")) {
            $query->where("from_tg_id", $condition["from_tg_id"]);
        }

        $query->orderBy("id", "asc");

        return obj_to_array($query->get());
    }
}