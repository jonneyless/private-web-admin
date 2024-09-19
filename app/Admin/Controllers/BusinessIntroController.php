<?php

namespace App\Admin\Controllers;

use App\Models\Business;
use App\Models\BusinessIntro;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class BusinessIntroController extends AdminController
{
    protected $title = '业务介绍';

    protected $description = [
        'index' => " ",
    ];

    protected function grid()
    {
        $grid = new Grid(new BusinessIntro());

        $grid->model()
            ->query();

        $grid->column('id', 'ID')->sortable();
        $grid->column('business_id', "业务")->display(function () {
            return $this->business->name;
        });
        $grid->column('keywords', "关键字");
        $grid->column('intro', "介绍文字");

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
        $form = new Form(new BusinessIntro());

        $form->select('business_id', __('业务'))->options(Business::getSelectData())->rules('required');
        $form->text('intro', __('欢迎语'));
        $form->tags('keywords', __('关键词'));

        $form->table('buttons', __('按钮组'), function ($table) {
            $table->text('name', __('文字'));
            $table->text('message', __('消息'));
        });

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
