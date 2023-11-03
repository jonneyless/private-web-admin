<?php

namespace App\Service;

class AssistService
{
    public static function getMediaFullName($user_tg_id, $file_name)
    {
        return config("constants.media_domain") . $user_tg_id . "/" . $file_name;
    }
}