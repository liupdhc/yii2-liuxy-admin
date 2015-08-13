<?php
/**
 * User: liupeng
 * Date: 2015/6/14
 * File Name: AbstractAsset.php
 */

namespace liuxy\admin\assets\plugins;

use liuxy\admin\assets\AbstractAsset;

abstract class PluginsAsset extends AbstractAsset {
    /**
     * @inheritdoc
     */
    protected $plugin_depends = [
        'liuxy\admin\assets\ThemeAsset'
    ];
}