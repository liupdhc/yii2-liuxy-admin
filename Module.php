<?php

namespace liuxy\admin;

use Yii;

/**
 * Main backend module.
 */
class Module extends \yii\base\Module {

    public static function t( $message, $params = [], $language = null) {
        $content = $message;
        if (isset(Yii::$app->i18n->translations['common/backend'])) {
            $content = Yii::t('common/backend', $message, $params, $language);
        }
        if ($content == $message) {
            $content = Yii::t('liuxy/admin', $message, $params, $language);
        }
        return $content;
    }
}
