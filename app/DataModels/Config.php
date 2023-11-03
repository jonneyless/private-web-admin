<?php

namespace App\DataModels;

use App\Service\ConfigService;

class Config
{
    public static function index()
    {
        $verify_error_max_num = ConfigService::val("verify_error_max_num");
        $verify_status = ConfigService::val("verify_status");

        return view('config.index')->with(compact("verify_error_max_num", "verify_status"));
    }
}