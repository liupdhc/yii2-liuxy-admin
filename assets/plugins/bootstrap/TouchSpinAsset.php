<?php
/**
 * Copyright 2008-2015 OPPO Mobile Comm Corp., Ltd, All rights reserved.
 *
 * FileName: TouchSpinAsset.php
 * Author: liupeng
 * Date: 12/25/15
 */

namespace liuxy\admin\assets\plugins\bootstrap;


use liuxy\admin\assets\plugins\PluginsAsset;

/**
 * Class TouchSpinAsset
 * @package liuxy\admin\assets\plugins\bootstrap
 */
class TouchSpinAsset extends PluginsAsset {
    protected $plugin_css = [
        'plugins/bootstrap-touchspin/bootstrap.touchspin.min.css'
    ];
    protected $plugin_js = [
        'plugins/bootstrap-touchspin/bootstrap.touchspin.min.js',
    ];
}