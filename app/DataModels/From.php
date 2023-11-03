<?php

namespace App\DataModels;

use App\Service\AssistService;
use App\Service\UserService;
use App\Service\FromService;
use App\Service\MessageService;

class From
{
    public static function detail($id)
    {
        $from = FromService::one(compact("id"));
        if (!$from) {
            return "404 user";
        }

        $user = UserService::one($from["user_id"]);
        if (!$user) {
            return "404 admin";
        }

        $messages = MessageService::gets([
            "from_tg_id" => $from["user_tg_id"],
        ]);
        foreach ($messages as $key => $message) {
            if ($message["type"] > 1) {
                $messages[$key]["file_path"] = AssistService::getMediaFullName($from["user_tg_id"], $message["file_name"]);
            }
        }

        $fullname = $user["name"];

        return view("user.detail")->with(compact("messages", "fullname", "from"));
    }
}