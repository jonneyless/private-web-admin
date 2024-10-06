<?php

namespace App\Admin\Controllers;

use App\Models\SensitiveWords;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class SensitiveWordsController extends AdminController
{
    protected $title = '敏感词';

    protected $description = [
        'index' => " ",
    ];

    protected function grid()
    {
        $grid = new Grid(new SensitiveWords());

        $grid->model()
            ->query();

        $grid->column('name', "敏感词")->sortable();

        $grid->disableCreateButton(false);
        $grid->disableActions(false);
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->disableDelete(false);
        });
        $grid->paginate(100);

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new SensitiveWords());

        $form->text('name', __('敏感词'));

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
