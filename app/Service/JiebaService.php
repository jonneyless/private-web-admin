<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;

class JiebaService
{
    public static function get($start_at, $end_at)
    {
        if ($start_at == $end_at) {
            $end_at = date("Y-m-d", strtotime($end_at) + 1);
        }

        $data_temp = DB::select('SELECT info, count(*) as temp from message_jieba where LENGTH(info) >= 2 and created_at >= ? and created_at < ? GROUP BY info having temp > 100 order by temp desc', [$start_at, $end_at]);
        $data = [];
        foreach ($data_temp as $item) {
            array_push($data, [
                "info" => $item->info,
                "num" => $item->temp,
            ]);
        }

        return $data;
    }
}