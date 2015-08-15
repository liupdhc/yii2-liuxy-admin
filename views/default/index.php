<?php

/**
 * Backend main page view.
 *
 * @var yii\base\View $this View
 */

use liuxy\admin\Module;

?>

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html"><?=Module::t('admin', 'index')?></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#"><?=Module::t( 'index.dashboard')?></a>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->