<?php

namespace App\Admin\Controllers;

use App\DataModels\From as DataFrom;
use App\DataModels\FromBack as DataFromBack;
use App\Models\From;
use App\Service\FromService;
use App\Service\UserService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class FromController extends AdminController
{
    protected $title = '客户列表';
    protected $description = [
        'index' => " ",
    ];

    protected function grid()
    {
        $users = UserService::all();
        $users_filter = [];
        foreach ($users as $item) {
            $users_filter[$item["id"]] = $item["nickname"];
        }

        $grid = new Grid(new From());
        $grid->model()
            ->orderBy('updated_at', 'desc');

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();

            $filter->column(1 / 2, function ($filter) {
                $filter->equal('id', "id");
                $filter->equal('user_tg_id', "用户tgId");
                $filter->like('fullname', "昵称");
                $filter->like('username', "用户名");
                $filter->between('updated_at', "最近聊天时间")->datetime();
            });
        });

        $grid->column('id', 'ID')->sortable();
        $grid->column('user_tg_id', "user_tg_id");
        $grid->column('username', "username");
        $grid->column('firstname', "昵称");
        $grid->column('user_id', "分配人")->display(function ($user_id) {
            if (!$user_id) {
                return "未分配";
            }

            $admin = UserService::one([
                "id" => $user_id,
            ]);
            if (!$admin) {
                return "分配人不存在";
            }

            return $admin["nickname"] . " " . $admin["name"];
        })->filter($users_filter);

        $grid->column('status', "状态 ")->display(function ($status) {
            if ($status == 1) {
                return "<span class='label label-success'>正常</span>";
            } else {
                return "<span class='label label-danger'>封禁中</span>";
            }
        })->filter([
            1 => "正常",
            2 => "封禁中",
        ]);
        $grid->column('status_night', "夜间有无信息")->display(function ($status_night) {
            if ($status_night == 1) {
                return "<span class='label label-success'>无</span>";
            } else {
                return "<span class='label label-danger'>有</span>";
            }
        })->filter([
            1 => "无",
            2 => "有",
        ]);
        $grid->column('flag', "验证状态 ")->display(function ($flag) {
            if ($flag == 1) {
                return "<span class='label label-default'>待验证</span>";
            } elseif ($flag == 3) {
                return "<span class='label label-danger'>失败</span>";
            } elseif ($flag == 2) {
                return "<span class='label label-success'>成功</span>";
            }
        })->filter([
            1 => "待验证",
            2 => "成功",
            3 => "失败",
        ]);

        $grid->column('created_at', "开始时间")->sortable()->hide();
        $grid->column('updated_at', "最近聊天时间")->sortable();
        // $grid->column('deleted', "tg账号状态")->display(function ($i) {
        //     if ($i == 1) {
        //         return "<span class='label label-danger'>注销</span>";
        //     } else {
        //         return "<span class='label label-success'>正常</span>";
        //     }
        // })->filter([
        //     1 => "注销",
        //     2 => "正常",
        // ]);

        $grid->disableFilter(false);
        $grid->disableCreateButton();
        $grid->disableActions(false);
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView(false);
            $actions->disableEdit();
            $actions->disableDelete();
        });

        $grid->paginate(100);

        return $grid;
    }

    public function show($id, Content $content)
    {
        return $content
            ->title($this->title)
            ->description($this->description['index'])
            ->row(function (Row $row) use ($id) {
                $row->column(12, function (Column $column) use ($id) {
                    $column->append(DataFrom::detail($id));
                });
            });
    }

    public function fromback($id, Content $content)
    {
        return $content
            ->title($this->title)
            ->description($this->description['index'])
            ->row(function (Row $row) use ($id) {
                $row->column(12, function (Column $column) use ($id) {
                    $column->append(DataFromBack::detail($id));
                });
            });
    }

    public function changeFlag()
    {
        $parameters = request()->all();

        if (is_wrong_data($parameters, "from_id")) {
            return handle_response([], "error");
        }
        if (is_wrong_data($parameters, "flag")) {
            return handle_response([], "error");
        }

        $from_id = $parameters["from_id"];
        $flag = $parameters["flag"];

        $fromer = FromService::one([
            "id" => $from_id,
        ]);
        if (!$fromer) {
            return handle_response([], "操作成功");
        }

        $fromer->flag = $flag;
        $fromer->verify_error_num = 0;
        $fromer->reason = "";

        $fromer->save();

        return handle_response([], "操作成功");
    }

    public function changeStatus()
    {
        $parameters = request()->all();

        if (is_wrong_data($parameters, "from_id")) {
            return handle_response([], "error");
        }
        if (is_wrong_data($parameters, "status")) {
            return handle_response([], "error");
        }

        $from_id = $parameters["from_id"];
        $status = $parameters["status"];

        $fromer = FromService::one([
            "id" => $from_id,
        ]);
        if (!$fromer) {
            return handle_response([], "操作成功");
        }

        $fromer->status = $status;
        $fromer->save();

        return handle_response([], "操作成功");
    }
}
