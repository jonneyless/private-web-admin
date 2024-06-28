<?php

namespace App\Admin\modals;

use App\Service\AssistService;
use App\Service\FromService;
use App\Service\MessageService;
use App\Service\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Cache;

class Messages implements Renderable
{
    public function render($id = null)
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

            $k = sprintf("userinfo%s", $message["user_id"]);
            if (Cache::has($k)) {
                $obj = Cache::get($k);

                $messages[$key]["fullname"] = $obj["name"] . " " . $obj["nickname"];
            } else {
                $obj = UserService::one($message["user_id"]);
                if ($obj) {
                    Cache::put($k, $obj, 60);

                    $messages[$key]["fullname"] = $obj["name"] . " " . $obj["nickname"];
                } else {
                    $message[$key]["fullname"] = "";
                }
            }
        }

        $fullname = $user["name"];

        return view("user.modal-detail")->with(compact("messages", "fullname", "from"));
    }
}