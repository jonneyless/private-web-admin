<?php

namespace App\Admin\Controllers;

use App\DataModels\Home;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    protected $title = '首页';
    protected $description = [
        'index' => "担保",
    ];

    public function index(Content $content)
    {
        return $content
            ->title($this->title)
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append(Home::index());
                });
            });
    }
}
