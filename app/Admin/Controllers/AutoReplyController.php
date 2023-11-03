<?php

namespace App\Admin\Controllers;

use App\Models\AutoReply;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AutoReplyController extends AdminController
{
    protected $title = '自动回复';
    protected $description = [
        'index' => " ",
    ];

    protected function grid()
    {
        $grid = new Grid(new AutoReply());

        $grid->column('key', "问题");
        $grid->column('val', "回复")->limit(20);

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

    public function form()
    {
        $form = new Form(new AutoReply());

        $form->text('key', "问题")->disable();
        $form->textarea('val', "回复")->rows(20);

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }
}
