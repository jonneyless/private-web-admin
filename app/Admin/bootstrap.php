<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use App\Admin\Extensions\WangEditor;

Encore\Admin\Form::forget(['map', 'editor']);

Form::extend('editor', WangEditor::class);

Grid::init(function (Grid $grid) {
    $grid->disablePagination(false);
    $grid->disableCreateButton(false);
    $grid->disableFilter();
    $grid->disableRowSelector();
    $grid->disableColumnSelector();
    $grid->disableTools(false);
    $grid->disableExport();
    $grid->disableActions(false);
    $grid->actions(function (Grid\Displayers\Actions $actions) {
        $actions->disableView();
        $actions->disableEdit();
        $actions->disableDelete();
    });
});

Admin::css('/css/init.css');