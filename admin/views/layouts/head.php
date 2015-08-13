<?php

/**
 * Head layout.
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>
    <title><?= Html::encode($this->title); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="<?= Html::encode($this->title); ?>" name="description"/>
    <meta content="" name="author"/>
<?= Html::csrfMetaTags(); ?>
<?php $this->head(); ?>

<?php

$this->registerMetaTag(
    [
        'charset' => Yii::$app->charset
    ]
);
$this->registerMetaTag(
    [
        'name' => 'viewport',
        'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
    ]
);
$this->registerLinkTag(
    [
        'rel' => 'canonical',
        'href' => Url::canonical()
    ]
); ?>