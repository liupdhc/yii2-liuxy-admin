<?php
/**
 * User: liupeng
 * Date: 2015/6/14
 * File Name: JqvMapAsset.php
 */

namespace liuxy\admin\assets\plugins\jquery;

use liuxy\admin\assets\plugins\PluginsAsset;

class FlotAsset extends PluginsAsset {

    protected $plugin_js = [
        'plugins/flot/jquery.flot.min.js',
        'plugins/flot/jquery.flot.resize.min.js',
        'plugins/flot/jquery.flot.categories.min.js',
    ];
}