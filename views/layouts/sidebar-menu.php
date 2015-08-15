<?
use liuxy\admin\widgets\Menu;

?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
            <?php
            echo Menu::widget(['menuItems'=>$menus,'currentItem'=>$current]);?>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->