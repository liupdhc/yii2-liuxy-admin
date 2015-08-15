<?php
/**
 * Author: liupeng
 * Date: 2015/7/12
 */

namespace liuxy\admin\widgets;

use liuxy\admin\components\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * 工具提示widget
 * Class Tool
 *
 * @package liuxy\themes\admin\widgets
 */
class Tools extends Widget {

    /**
     *
     * @var string
     */
    public $content = '';

    public $items = false;

    /**
     * Initializes the widget.
     */
    public function init() {
        parent::init();
        echo Html::beginTag('div', ['class' => 'portlet']) . "\n";
        echo Html::beginTag('div', ['class' => 'portlet-title ']) . "\n";
        echo Html::beginTag('div', ['class' => 'tools']) . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run() {
        echo "\n" . $this->renderTools();
        echo "\n" . Html::endTag('div'); // modal-content
        echo "\n" . Html::endTag('div'); // modal-content
        echo Html::beginTag('div', ['class' => 'portlet-body']) . "\n";
        echo $this->content."\n";
        echo "\n" . Html::endTag('div');
    }

    /**
     *  渲染工具列表
     */
    protected function renderTools() {
        if ($this->items) {
            $toolsContent = '';
            foreach($this->items as $item) {
                $innerContent = '';
                if ($item['icon']) {
                    $innerContent = Html::tag('i','',['class'=>$item['icon']]);
                }
                $options = isset($item['options']) ? $item['options'] : [];
                $toolsContent .= Html::tag('a', $innerContent.$item['label'],
                    ArrayHelper::merge(['data-original-title' => $item['title'], 'title' => $item['title']],
                        $options));
                unset($innerContent);
                unset($options);
            }
            return $toolsContent;
        }
        return '';
    }
}