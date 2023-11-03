<?php

namespace App\Admin\Controllers;

use App\Models\Quick;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class QuickController extends AdminController
{
    protected $title = '自动回复';
    protected $description = [
        'index' => " ",
    ];

    protected function grid()
    {
        $grid = new Grid(new Quick());

        $grid->column('id', 'ID')->sortable();
        $grid->column('msg', "自动回复");

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
        $show = new Show(Quick::findOrFail($id));

        $show->field('msg', '自动回复');

        return $show;
    }

    public function form()
    {
        $form = new Form(new Quick());

        $form->text('msg', "自动回复");

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
