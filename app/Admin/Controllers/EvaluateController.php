<?php

namespace App\Admin\Controllers;

use App\Models\LogEvaluate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Service\UserService;
use Encore\Admin\Facades\Admin as FacadesAdmin;

class EvaluateController extends AdminController
{
    protected $title = '评价';
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
        
        $grid = new Grid(new LogEvaluate());
        $grid->model()
            ->orderBy('id', 'desc');
            
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();

            $filter->column(1 / 2, function ($filter) {
                $filter->equal('from_tg_id', "客户tgid");
                $filter->like('from_fullname', "客户昵称");
                $filter->between('created_at', "开始时间")->datetime();
            });
        });

        $grid->column('id', 'ID')->sortable();
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
        $grid->column('from_tg_id', '客户tgid');
        $grid->column('from_username', '客户用户名');
        $grid->column('from_fullname', '客户昵称');
        $grid->column('num', "评分")->display(function ($num) {
            if ($num == 1) {
                return "<span class='label label-success'>好评</span>";
            } elseif ($num == 2) {
                return "<span class='label label-warning'>中评</span>";
            } elseif ($num == 3) {
                return "<span class='label label-danger'>差评</span>";
            } else {
                return "<span class='label label-default'>未评价</span>";
            }
        })->filter([
            1 => "好评",
            2 => "中评",
            3 => "差评",
        ]);
        $grid->column('typee', "中差评原因")->display(function ($typee) {
            if ($typee == 1) {
                return "<span class='label label-default'>效率慢</span>";
            } elseif ($typee == 2) {
                return "<span class='label label-default'>态度差</span>";
            } elseif ($typee == 3) {
                return "<span class='label label-default'>业务不熟</span>";
            }
        })->filter([
            1 => "效率慢",
            2 => "态度差",
            3 => "业务不熟",
        ]);
        $grid->column('info', '评价')->limit(20);
        $grid->column('remark', '评语')->limit(20);
        $grid->column('from_id', '记录')->display(function ($from_id) {
            return sprintf("<a href='%s' target='_blank'>详情</a>", "/ayivj/from/" . $from_id);
        });
        $grid->column('created_at', "创建时间")->sortable();

        $grid->expandFilter();
    
        $grid->disableFilter(false);
        $grid->disableCreateButton();
        $grid->disableActions(false);
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit(false);
            $actions->disableDelete();
        });

        $grid->paginate(100);

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(LogEvaluate::findOrFail($id));

        $show->field('remark', '评语');

        return $show;
    }

    public function form()
    {
        $form = new Form(new LogEvaluate());

        $form->text('remark', "评语");

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });
        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableCreatingCheck();
            $footer->disableEditingCheck();
        });

        return $form;
    }
}
