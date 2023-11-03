<?php

namespace App\Service;

use App\Models\User;

class UserService
{
    public static function one($id)
    {
        $query = User::query();

        $query->where("id", $id);

        return $query->first();
    }
    
    public static function all()
    {
        $query = User::query();
        
        return $query->get();
    }
}