<?
use liuxy\admin\Module;
use yii\helpers\Url;
$currentUser = \liuxy\admin\models\AdminUser::getUser();
?>
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="index.html">
                <img src="<?=Yii::$app->assetManager->getPublishedUrl('@liuxy/themes/admin')?>/img/logo.png" alt="logo" class="logo-default"/>
            </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <div class="hor-menu hor-menu-light hidden-sm hidden-xs">
        <ul class="nav navbar-nav">
            <?if($menus) {
                foreach($menus as $menu){
                    if ($menu != \liuxy\admin\models\Permission::NAV_YES) {
                        continue;
                    }
            ?>
            <li class="classic-menu-dropdown <?if($current['id'] == $menu['id']){ echo 'active';}?>">
                <a href="javascript:void(0)" onclick="liuxy.redirect('<?=$menu['link']?>')">
                    <?=$menu['name']?>
                    <?if($current['id'] == $menu['id']){?>
                        <span class="selected"></span>
                    <?}?>
                </a>
            </li>
            <?}}?>
        </ul>
        </div>
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">


                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="<?=Yii::$app->assetManager->getPublishedUrl('@liuxy/themes/admin')?>/img/avatar3_small.jpg"/>
					<span class="username username-hide-on-mobile">
					<?=$currentUser->username?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="<?=Url::toRoute('/admin/user/profile')?>">
                                <i class="icon-user"></i><?=Module::t('user.info')?></a>
                        </li>
                        <li>
                            <a href="<?=Url::toRoute('/admin/default/logout')?>">
                                <i class="icon-key"></i><?=Module::t('user.logout')?></a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->