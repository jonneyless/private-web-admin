<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use App\Models\Business;
use App\Service\UserClientService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;

class BusinessController extends AdminController
{
    protected $title = '业务列表';
    protected $description = [
        'index' => " ",
    ];

    protected function grid()
    {
        $grid = new Grid(new Business());
        
        $grid->model()
            ->query()
            ->orderBy("orderr", "asc");

        // $grid->column('id', 'ID')->sortable();
        $grid->column('name', "名称")->editable();
        $grid->column('orderr', "排序")->editable()->sortable();
        $grid->column('status', "状态")->filter([
            1 => '开启',
            2 => '关闭',
        ])->radio([
            1 => '开启',
            2 => '关闭',
        ]);
        $grid->column('reply', "自动回复(无客服情况)")->editable('textarea');
        $grid->column('is_default', "默认业务")->display(function ($is_default) {
            if ($is_default == 1) {
                return "<span class='label label-success'>默认业务</span>";
            } else {
                return "<span class='label label-default'>否</span>";
            }
        });
        $grid->column('is_yanqun', "验群业务")->display(function ($is_yanqun) {
            if ($is_yanqun == 1) {
                return "<span class='label label-success'>验群业务</span>";
            } else {
                return "<span class='label label-default'>否</span>";
            }
        });
        $grid->column('is_ziyuan', "资源业务")->display(function ($is_ziyuan) {
            if ($is_ziyuan == 1) {
                return "<span class='label label-success'>资源业务</span>";
            } else {
                return "<span class='label label-default'>否</span>";
            }
        });
        
        $grid->disableCreateButton(false);
        $grid->disableActions();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->disableDelete();
        });
        $grid->paginate(100);

        return $grid;
    }
    
    protected function form()
    {
        $form = new Form(new Business());

        $form->text('name', __('名称'))->rules('required');
        $form->text('orderr', __('排序'));
        $form->radio('status', __('状态'))->options(['1' => '开启', '2' => '关闭'])->default('1');
        $form->text('reply', __('自动回复(无客服情况)'));

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
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
