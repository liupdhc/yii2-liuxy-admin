<?php
/**
 * Created by liupeng.
 * Date: 2015/7/1
 * File: SelectAsset.php
 */

namespace liuxy\admin\assets\plugins\jquery;

use liuxy\admin\assets\plugins\PluginsAsset;

class SelectAsset extends PluginsAsset {
    protected $plugin_css = [
        'plugins/bootstrap-select/bootstrap-select.min.css',
        'plugins/select2/select2.css',
        'plugins/jquery-multi-select/css/multi-select.css'
    ];

    protected $plugin_js = [
        'plugins/bootstrap-select/bootstrap-select.min.js',
        'plugins/select2/select2.min.js',
        'plugins/jquery-multi-select/js/jquery.multi-select.js'
    ];
} 