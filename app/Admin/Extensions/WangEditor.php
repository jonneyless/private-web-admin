<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class WangEditor extends Field
{
    protected $view = 'admin.wang-editor';
    public $width = 2;

    protected static $css = [
        '/vendor/wangeditor/release/wangEditor.min.css',
    ];

    protected static $js = [
        '/vendor/wangeditor/release/wangEditor.min.js',
    ];

    public function self_width($width)
    {

    }

    public function render()
    {
        $token = csrf_token();
        $name = $this->formatName($this->column);

        $this->script = <<<EOT

var E = window.wangEditor
var editor = new E('#{$this->id}');
editor.customConfig.menus = [
]
editor.customConfig.uploadFileName = 'img_editor'
editor.customConfig.uploadImgServer = '/admin/upload/editor'
editor.customConfig.zIndex = 0
editor.customConfig.uploadImgParams = {
    '_token': '$token'
}
editor.customConfig.onchange = function (html) {
    $('input[name=\'$name\']').val(html);
}
editor.create()

EOT;
        return parent::render();
    }
}