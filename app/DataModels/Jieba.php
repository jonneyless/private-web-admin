<?php

namespace App\DataModels;

class Jieba
{
    public static function index()
    {
        $today = date("Y-m-d");
        $yesterday = date("Y-m-d", strtotime($today) - 86400);

        $start_at = $yesterday;
        $end_at = $today;

        return view('jieba.index')->with(compact("start_at", "end_at"));
    }
}