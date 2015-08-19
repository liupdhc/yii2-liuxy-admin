<?php

namespace liuxy\admin;

use yii\base\BootstrapInterface;

/**
 * liuxy module bootstrap class.
 */
class Bootstrap implements BootstrapInterface {
    /**
     * @inheritdoc
     */
    public function bootstrap($app) {
        // Add module URL rules.
        $app->getUrlManager()->addRules(
            [
                '' => \Yii::$app->defaultRoute,
                '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',
                '<_m>/<_c>/<_a>.json' => '<_m>/<_c>/<_a>'
            ]
        );

        // Add module I18N category.
        if (!isset($app->i18n->translations['liuxy/admin']) && !isset($app->i18n->translations['liuxy/*'])) {
            $app->i18n->translations['liuxy/admin'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@liuxy/admin/views/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'liuxy/admin' => 'admin.php',
                ]
            ];
        }
    }
}
