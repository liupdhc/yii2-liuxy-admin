<?php

namespace liuxy\admin;

use Yii;

/**
 * Class Theme
 * @package liuxy\admin
 */
class Theme extends \yii\base\Theme {
    /**
     * @inheritdoc
     */
    public $pathMap = [
        '@backend/views' => '@liuxy/admin/views',
    ];

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
            'css' => [
                'css/bootstrap.min.css'
            ]
        ];
        Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = [
            'js' => [
                'js/bootstrap.min.js'
            ]
        ];
        Yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = [
            'js' => [
                'jquery.min.js'
            ]
        ];
        Yii::$app->assetManager->bundles['yii\jui\JuiAsset'] = [
            'js' => [
                'jquery-ui.min.js'
            ]
        ];
    }
}
