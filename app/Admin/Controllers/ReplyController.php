<?php

namespace App\Admin\Controllers;

use App\Models\Reply;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ReplyController extends AdminController
{
    protected $title = '快捷回复';
    protected $description = [
        'index' => " ",
    ];

    protected function grid()
    {
        $grid = new Grid(new Reply());

        $grid->column('id', 'ID')->sortable();
        $grid->column('info', "快捷回复")->limit(150);

        $grid->disableCreateButton(false);
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
        $form = new Form(new Reply());

        $form->editor('info', "快捷回复");

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
    
    // protected function detail($id)
    // {
    //     $show = new Show(Reply::findOrFail($id));

    //     $show->field('info', '快捷回复');

    //     return $show;
    // }
}
