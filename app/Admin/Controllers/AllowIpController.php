<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use App\Models\AllowIp;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;

class AllowIpController extends AdminController
{
    protected $title = 'ip白名单';
    protected $description = [
        'index' => " ",
    ];

    protected function grid()
    {
        $grid = new Grid(new AllowIp());
        
        $grid->model()
            ->query()
            ->orderBy("id", "asc");

        // $grid->column('id', 'ID')->sortable();
        $grid->column('ip', "ip");
        $grid->column('remark', "备注")->limit(50);
        
        $grid->disableCreateButton(false);
        $grid->disableActions(false);
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit(false);
            $actions->disableDelete(false);
        });
        $grid->paginate(100);

        return $grid;
    }
    
    protected function form()
    {
        $form = new Form(new AllowIp());

        $form->text('ip', __('ip'))->rules('required');
        $form->text('remark', __('备注'));

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
