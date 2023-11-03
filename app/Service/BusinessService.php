<?php

namespace App\Service;

use App\Models\Business;

class BusinessService
{
    public static function get()
    {
        return Business::query()->get();
    }
    
    public static function one($id)
    {
        return Business::query()->where("id", $id)->first();
    }
}