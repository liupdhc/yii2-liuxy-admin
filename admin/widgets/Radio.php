<?php
/**
 * Author: liupeng
 * Date: 2015/7/11
 */

namespace liuxy\admin\widgets;

use liuxy\admin\components\helpers\Html;

/**
 * 单选框
 * Class Radio
 *
 * @package liuxy\themes\admin\widgets
 */
class Radio extends Checkbox {
    /**
     * @inheritDoc
     */
    protected function renderContent($value) {
        return Html::radio($this->name, in_array($value, $this->values), ['class'=>'icheck','data-radio'=>'iradio_'.$this->style.'-'.$this->color,'value'=>$value]);
    }

}