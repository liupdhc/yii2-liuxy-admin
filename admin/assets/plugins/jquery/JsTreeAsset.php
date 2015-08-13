<?php
/**
 * author: liupeng
 * createTime: 2015/6/24 1:48
 * description: ${TODO}
 * file: JsTreeAsset.php
 */

namespace liuxy\admin\assets\plugins\jquery;


use liuxy\admin\assets\plugins\PluginsAsset;

/**
 * 树形操作
 * Class JsTreeAsset
 * @package liuxy\themes\admin\assets\plugins\jquery
 */
class JsTreeAsset extends PluginsAsset {

    protected $plugin_css = [
      'plugins/jstree/dist/themes/default/style.min.css'
    ];

    protected $plugin_js = [
        'plugins/jstree/dist/jstree.min.js'
    ];
} 