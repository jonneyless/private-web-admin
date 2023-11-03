<?php

namespace App\Admin\Controllers;

use App\DataModels\Config;
use App\Service\ConfigService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class ConfigController extends AdminController
{
    protected $title = '配置管理';
    protected $description = [
        'index' => " ",
        "show" => " ",
    ];

    public function index(Content $content)
    {
        return $content
            ->title($this->title)
            ->description($this->description['index'])
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append(Config::index());
                });
            });
    }

    public function change()
    {
        $parameters = request()->all();
        if (is_wrong_data($parameters, "key")) {
            return handle_response([], "error");
        }
        if (is_wrong_data($parameters, "val")) {
            // return handle_response([], "error");
        }

        $config = ConfigService::get($parameters["key"]);
        if (!$config) {
            return handle_response([], "error");
        }

        ConfigService::set($config, $parameters["val"]);
        
        return handle_response([], "成功");
    }
}