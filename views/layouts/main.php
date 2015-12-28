<?php

/**
 * Theme main layout.
 *
 * @var \yii\web\View $this View
 * @var string $content Content
 */

use liuxy\admin\assets\PagesScriptAsset;
use liuxy\admin\Module;

?>
<?php
PagesScriptAsset::register($this);?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <!--[if IE 8]> <html lang="<?= Yii::$app->language ?>" class="ie8 no-js"> <![endif]-->
    <!--[if IE 9]> <html lang="<?= Yii::$app->language ?>" class="ie9 no-js"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="<?= Yii::$app->language ?>" class="no-js">
    <!--<![endif]-->
    <head>
        <?= $this->render('//layouts/head') ?>
		<script type="text/javascript">
			var _callbacks = [];//注册加载后调用函数列表
			var baseUrl = '<?=Yii::$app->request->getBaseUrl ()?>';
		</script>
    </head>
	<body class="page-header-fixed page-quick-sidebar-over-content page-style-square">
    <?php $this->beginBody();?>

	<?= $this->render('//layouts/page-header',['menus'=>isset($topMenu) ? $topMenu : false,'current'=>isset($topItem) ? $topItem : false]) ?>
	<div class="clearfix"></div>
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<?= $this->render('//layouts/sidebar-menu',['menus'=>isset($subMenu) ? $subMenu : false,'current'=>isset($current) ? $current : false]) ?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content"">

			<!-- BEGIN PAGE HEADER-->
			<div class="page-bar">
			    <ul class="page-breadcrumb">
			        <li>
			            <i class="fa fa-home"></i>
			            <a href="<?=\yii\helpers\Url::toRoute('/')?>"><?=Module::t( 'index')?></a>
			            <i class="fa fa-angle-right"></i>
			        </li>
			        <?if(isset($breads)){
						$start = false;
			        	foreach ($breads as $bread) {
							?>
			        <li>
						<?
						if ($start) {?>
							<i class="fa fa-angle-right"></i>
						<?} else {
							$start = true;
						}?>
			        	<?if (isset($bread['url']) && !empty($bread['url'])){?>
			            <a href="<?=\yii\helpers\Url::toRoute('/'.$bread['url'])?>"><?=$bread['name']?></a>
			            <?}else{?>
			            <?=$bread['name']?>
			            <?}?>
			        </li>
			        <?}}?>
			    </ul>
			</div>
			<!-- END PAGE HEADER-->
			<?php echo $content; ?>
			</div>
		</div>
		<!-- END CONTENT -->
	</div>
	<!-- END CONTAINER -->

	<?= $this->render('//layouts/footer') ?>
    <?php $this->endBody(); ?>
    <script type="text/javascript">
        $(function() {
            JUI.init(); // init metronic core componets
			Layout.init(); // init layout
			Demo.init(); // init demo features
			for(var i=0;i<_callbacks.length;i++){
				_callbacks[i]();
			}
            bootbox.setDefaults({"locale":"zh_CN","size":"small"});
        });
    </script>
    </body>
</html>
<?php $this->endPage(); ?>