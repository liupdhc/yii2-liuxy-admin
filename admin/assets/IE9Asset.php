<?php
/**
 * author: liupeng
 * createTime: 2015/6/5 3:43
 * description: ${TODO}
 * file: IE9Asset.php
 */

namespace liuxy\admin\assets;

class IE9Asset extends AbstractAsset {

    public $jsOptions = ['condition'=>'lte IE 9'];
    public $cssOptions = ['condition'=>'lte IE 9'];

    public $plugin_js = [
        'plugins/respond.min.js',
        'plugins/excanvas.min.js'
    ];
} 