<?php
/**
 * FileName: ICheckAsset.php.
 * Author: liupeng
 * Date: 2015/7/26
 */

namespace liuxy\admin\assets\plugins\jquery;


use liuxy\admin\assets\plugins\PluginsAsset;

/**
 * checkbox/radio插件
 * Class ICheckAsset
 * @package liuxy\themes\admin\assets\plugins\jquery
 */
class ICheckAsset extends PluginsAsset {
    protected $plugin_js = [
        'plugins/icheck/icheck.min.js'
    ];

    protected $plugin_css = [
        'plugins/icheck/skins/all.css'
    ];
}