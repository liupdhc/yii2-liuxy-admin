<?php

namespace liuxy\admin\widgets;

use liuxy\admin\models\Permission;
use yii\helpers\Html;

/**
 * 导航菜单
 * Class Menu
 * @package liuxy\themes\admin\widgets
 * Theme menu widget.
 */
class Menu extends \yii\base\Widget {
    const DEFAULT_LISTICON = 'icon-list';
    const DEFAULT_ITEMICON = 'icon-login';

    public $menuItems = [];

    /**
     * @var \liuxy\admin\models\Permission
     */
    public $currentItem = false;

    /**
     * (non-PHPdoc)
     * @see \yii\base\Widget::run()
     */
    public function run() {
        $content = '';
        if ($this->menuItems) {
            foreach ($this->menuItems as $item) {
                if ($item['is_nav'] != Permission::NAV_YES) {
                    continue;
                }
                $sub = '';
                $cssOptions = [];
                $opened = false;
                if (isset($item['sub'])) {
                    $curr = $this->renderSub($item['sub'], $sub);
                    if ($curr) {
                        Html::addCssClass($cssOptions, 'open');
                        $opened = true;
                    }
                }
                if ($item['id'] == $this->currentItem->parent_id || $item['id'] == $this->currentItem->id || $opened) {
                    Html::addCssClass($cssOptions, 'active');
                }

                $content .= Html::beginTag('li', $cssOptions);
                $content .= $this->renderParentLink($item, $opened);
                $content .= $sub;
                $content .= Html::endTag('li');
            }
        }

        return Html::tag('ul', $content, [
            'class' => 'page-sidebar-menu',
            'data-keep-expanded'=>'false',
            'data-auto-scroll'=>'true',
            'data-slide-speed'=>"200"
        ]);
    }

    protected function renderParentLink($item, $opened) {
        $iconOptions = [];
        $content = '';
        if (!empty ($item ['icon'])) {
            Html::addCssClass($iconOptions, $item ['icon']);
        } else {
            Html::addCssClass($iconOptions, !isset($item['sub']) ? self::DEFAULT_ITEMICON : self::DEFAULT_LISTICON);
        }
        $content .= Html::tag('i', '', $iconOptions);
        unset ($iconOptions);

        $content .= Html::tag('span', $item['name'], ['class' => 'title']);
        if ($item['id'] == $this->currentItem->id) {
            $content .= Html::tag('span', '', ['class' => 'selected']);
        }
        if (isset($item['sub'])) {
            $cssOptions = [];
            Html::addCssClass($cssOptions, 'arrow');
            if ($opened) {
                Html::addCssClass($cssOptions, 'open');
                $content .= Html::tag('span', '', ['class'=>'selected']);
            }
            $content .= Html::tag('span', '', $cssOptions);
        }

        return Html::tag('a', $content, ['href' => 'javascript:;', 'onclick' => 'liuxy.redirect(\''.$item['link'].'\')']);
    }

    /**
     * 渲染子元素
     */
    protected function renderSub($item, &$sub) {
        $content = '';
        $ret = false;
        foreach ($item as $subitem) {
            if ($subitem['is_nav'] != Permission::NAV_YES) {
                continue;
            }
            $substr = '';
            $cssOptions = [];
            $opened = false;
            if (isset($subitem['sub'])) {
                $curr = $this->renderSub ( $subitem ['sub'] ,$substr);
                if ($curr) {
                    Html::addCssClass($cssOptions, 'open');
                    $opened = true;
                    $ret = true;
                }
            }
            if ($this->currentItem->id == $subitem['id']) {
                Html::addCssClass($cssOptions, 'active');
                $ret = true;
                $content .= Html::beginTag('li', $cssOptions);
            } else {
                $content .= Html::beginTag('li', $cssOptions);
            }
            $content .= $this->renderLink($subitem, $opened);
            $content .= $substr;
            $content .= Html::endTag('li');
        }
        if ($ret) {
            $sub = Html::tag('ul', $content, [
                'class' => 'sub-menu','style'=>'display:block'
            ]);
        } else {
            $sub = Html::tag('ul', $content, [
                'class' => 'sub-menu'
            ]);
        }
        return $ret;
    }

    /**
     * 渲染链接
     * @param unknown $item
     * @param string $isSub
     */
    protected function renderLink($item,$opened = false) {
        $iconOptions = [];
        $content = '';
        if (!empty ($item ['icon'])) {
            Html::addCssClass($iconOptions, $item ['icon']);
        } else {
            Html::addCssClass($iconOptions, self::DEFAULT_ITEMICON);
        }
        $content .= Html::tag('i', '', $iconOptions);
        $content .= PHP_EOL;
        unset ($iconOptions);
        $content.=$item['name'];
        if (isset($item['sub'])) {
            if ($opened) {
                $content .= Html::tag('span', '', ['class' => 'arrow open']);
            } else {
                $content .= Html::tag('span', '', ['class' => 'arrow']);
            }
        }

        return Html::tag('a', $content, ['href' => 'javascript:;', 'onclick' => 'liuxy.redirect(\''.$item['link'].'\')']);
    }
}
