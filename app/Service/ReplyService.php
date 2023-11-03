<?php

namespace App\Service;

use App\Models\Reply;

class ReplyService
{
    public static function data()
    {
        $data = Reply::query()->select("id", "info as title")->get();

        return obj_to_array($data);
    }
}