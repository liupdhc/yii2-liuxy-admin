<?php

/**
 * Copyright 2008-2015 OPPO Mobile Comm Corp., Ltd, All rights reserved.
 *
 * FileName: FileInputAsset.php
 * Author: liupeng
 * Date: 10/10/15
 */
namespace liuxy\admin\assets\plugins\bootstrap;

use liuxy\admin\assets\plugins\PluginsAsset;
class FileInputAsset extends PluginsAsset {
    protected $plugin_css = [
        'plugins/bootstrap-fileinput/bootstrap-fileinput.css'
    ];
    protected $plugin_js = [
        'plugins/bootstrap-fileinput/bootstrap-fileinput.js',
    ];
}