<?php
/**
 * User: liupeng
 * Date: 2015/6/14
 * File Name: PagesAsset.php
 */

namespace liuxy\admin\assets;

use Yii;

class PagesScriptAsset extends AbstractAsset {

    /**
     * @inheritdoc
     */
    protected $plugin_css = [
        'css/admin.min.css'
    ];

    protected $plugin_js = [
        'scripts/admin.min.js',
        'scripts/locales/admin-lang.zh-CN.min.js'
    ];

    /**
     * @inheritdoc
     */
    protected $plugin_depends = [
        'liuxy\admin\assets\ThemeAsset'
    ];

    public static function registerFile($view, $js) {
        if (is_array($js)) {
            foreach($js as $item) {
                $view->registerJsFile(Yii::$app->assetManager->getPublishedUrl('@liuxy/themes/admin').'/scripts/pages/'.$item,
                    ['depends'=>['liuxy\admin\assets\ThemeAsset']]);
            }
        } else {
            $view->registerJsFile(Yii::$app->assetManager->getPublishedUrl('@liuxy/themes/admin').'/scripts/pages/'.$js,
                ['depends'=>['liuxy\admin\assets\ThemeAsset']]);
        }
    }
}