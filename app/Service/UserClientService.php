<?php

namespace App\Service;

use App\Models\UserClient;

class UserClientService
{
    public static function get_count($username)
    {
        return UserClient::query()->where("username", $username)
            ->count("id");
    }
}