<?php
/**
 * Author: liupeng
 * Date: 2015/7/12
 */

namespace liuxy\admin\widgets;

/**
 * \liuxy\themes\admin\widgets\Widget 是自定义Widget的基类
 * Class Widget
 *
 * @package liuxy\themes\admin\widgets
 * @since   1.0
 */
class Widget extends \yii\base\Widget {

    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @inheritDoc
     */
    public function init() {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }


}