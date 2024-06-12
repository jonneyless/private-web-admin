<?php

namespace App\Admin\Controllers;

use App\Models\OfficalKefu;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class OfficalKefuController extends AdminController
{
    protected $title = '客服白名单';

    protected $description = [
        'index' => " ",
    ];

    protected function grid()
    {
        $grid = new Grid(new OfficalKefu());

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();

            $filter->column(1 / 2, function ($filter) {
                $filter->equal('tg_id', "tg_id");
            });
        });

        $grid->model()
            ->query()
            ->orderBy("id", "asc");

        $grid->column('tg_id', "tg_id");
        $grid->column('username', "用户名");
        $grid->column('fullname', "昵称");

        $grid->disableCreateButton(false);
        $grid->disableActions(false);
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->disableDelete(false);
        });
        $grid->disableFilter(false);
        $grid->paginate(100);

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new OfficalKefu());

        $form->text('tg_id', __('tg_id'))->rules('required');
        $form->text('username', __('用户名'));
        $form->text('fullname', __('昵称'));

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
