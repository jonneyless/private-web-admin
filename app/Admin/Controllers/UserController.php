<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Service\BusinessService;
use App\Service\UserClientService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class UserController extends AdminController
{
    protected $title = '客服列表';
    protected $description = [
        'index' => " ",
    ];

    protected function grid()
    {
        $business = BusinessService::get();
        $business_data = [];
        foreach ($business as $item) {
            $business_data[$item["id"]] = $item["name"];
        }
        
        $grid = new Grid(new User());

        $grid->column('id', 'ID')->sortable();
        $grid->column('nickname', "昵称")->editable();
        $grid->column('name', "用户名");
        $grid->column('avatar', "登陆数目")->display(function () {
            $username = $this->name;
            
            return UserClientService::get_count($username);
        });
        $grid->column('business_id', "业务分类")->display(function ($id) {
            $business = BusinessService::one($id);
            if ($business) {
                return $business["name"];
            } else {
                return "";
            }
        })->filter($business_data);
        $grid->column('status', "状态")->filter([
            1 => '在线',
            2 => '离线',
        ])->radio([
            1 => '在线',
            2 => '离线',
        ]);

        $grid->column('created_at', "创建时间");

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
        $form = new Form(new User());

        $business = BusinessService::get();
        $business_data = [];
        foreach ($business as $item) {
            $business_data[$item["id"]] = $item["name"];
        }

        $form->text('nickname', __('昵称'));
        $form->text('name', __('用户名'));
        $form->password('password', "密码")->rules('required');
        $form->select("business_id", "业务分类")->options($business_data);
        $form->radio('status', __('状态'))->options(['1' => '在线', '2' => '离线'])->default('1');

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableCreatingCheck();
            $footer->disableEditingCheck();
        });
        
        $form->saving(function (Form $form) {
            if ($form->password) {
                $form->password = bcrypt($form->password);
            }
        });

        return $form;
    }
    
    public function store()
    {
        return $this->form()->store([
            "created_at" => date("Y-m-d H:i:s"),
        ]);
    }
}
