<?php
use liuxy\admin\Module;
use liuxy\admin\assets\PagesScriptAsset;
use liuxy\admin\widgets\ActiveForm;
?>
<?php
PagesScriptAsset::register($this);
$this->title = Module::t('login.title');?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?= $this->render('//layouts/head') ?>
    <script type="text/javascript">
        var baseUrl = '<?=Yii::$app->request->getBaseUrl ()?>';
    </script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<?php $this->beginBody();?>
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="index.html">
        <img src="<?=Yii::$app->assetManager->getPublishedUrl('@liuxy/themes/admin')?>/img/logo-big.png" alt=""/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php $form = ActiveForm::begin(['id' => 'login-form','action'=>'','options'=>['onsubmit'=>'return false;']]); ?>
    <h3 class="form-title"><?=Module::t( 'login.title')?></h3>
    <?= $form->field('username')->textInput(['placeholder'=>'login.username',
        'icon'=>'fa fa-user','autocomplete'=>'off']) ?>
    <?= $form->field('password')->passwordInput(['placeholder'=>'login.password',
        'icon'=>'fa fa-lock','autocomplete'=>'off']) ?>
    <div class="form-group">
            <button type="submit" id="btn-submit" class="btn green-haze pull-right">
                <?=Module::t('login.submit')?> <i class="m-icon-swapright m-icon-white"></i>
            </button>
    </div>
    <?php ActiveForm::end(); ?>
    <br />
    <br />
    <!-- END LOGIN FORM -->
</div>
<!-- END LOGIN -->

<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    <?=Module::t('footer.copyright')?>
</div>
<!-- END COPYRIGHT -->
<?php $this->endBody(); ?>
<script>
    jQuery(document).ready(function() {
        JUI.init(); // init metronic core components
        Layout.init(); // init current layout
        Demo.init();
        login.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php $this->endPage(); ?>