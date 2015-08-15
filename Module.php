<?php

namespace liuxy\admin;

use Yii;

/**
 * Main backend module.
 */
class Module extends \yii\base\Module {

    public static function t( $message, $params = [], $language = null) {
        return Yii::t('liuxy/admin', $message, $params, $language);
    }
}
