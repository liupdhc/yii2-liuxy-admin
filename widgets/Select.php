<?php
/**
 * Copyright 2008-2015 OPPO Mobile Comm Corp., Ltd, All rights reserved.
 * FileName:Select.php
 * Author:Administrator
 * Create Date:2015-11-24
 */

namespace liuxy\admin\widgets;
use liuxy\admin\components\helpers\Html;

/**
 * 下拉选择框,不支持optgroup分组
 * Class Select
 * @package liuxy\admin\widgets
 */
class Select extends Widget {

    /**
     * 选项列表值，[$key=>$val]的形式
     * @var array
     */
    public $items = [];

    public $id = false;

    /**
     * 当前值，用于默认选中
     * @var null
     */
    public $value = false;

    public function run () {
        return Html::tag('select', $this->renderOptions(),[
            'id'=>$this->id,
            'name'=>$this->id,
            'class'=>'form-control'
        ]);
    }

    /**
     * 渲染选项
     */
    protected function renderOptions() {
        $html = '';
        if ($this->items) {
            foreach ($this->items as $key=>$val) {
                $attr = ['value'=>$key];
                if ($this->value !== false && $this->value == $key) {
                    $attr['selected'] = 'true';
                }
                $html .= Html::tag ( 'option', $val, $attr );
                unset($attr);
            }
        }
        return $html;
    }
}