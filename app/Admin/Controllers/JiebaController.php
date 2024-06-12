<?php

namespace App\Admin\Controllers;

use App\DataModels\Jieba;
use App\Service\JiebaService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Http\Request;

class JiebaController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->title("客户信息统计")
            ->row(function (Row $row) {
                $row->column(8, function (Column $column) {
                    $column->append(Jieba::index());
                });
            });
    }

    public function data(Request $request)
    {
        $parameters = request()->all();

        $today = date("Y-m-d");
        $yesterday = date("Y-m-d", strtotime($today) - 86400);

        $start_at = $yesterday;
        $end_at = $today;
        if (is_right_data($parameters, "startTime") and is_right_data($parameters, "endTime")) {
            $start_at = $parameters["startTime"];
            $end_at = $parameters["endTime"];
        }

        $start = 0;
        $len = 100;
        if (is_right_data($parameters, "start") && is_right_data($parameters, "len")) {
            $start = $parameters["start"];
            $len = $parameters["len"];
        }

        $data = JiebaService::get($start_at, $end_at, $start, $len);

        return [
            "draw" => $request->get("draw"),
            'recordsTotal' => count($data),
            "recordsFiltered" => count($data),
            'data' => $data,
        ];
    }
}
