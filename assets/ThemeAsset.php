<?php

namespace liuxy\admin\assets;

/**
 * Theme main asset bundle.
 */
class ThemeAsset extends AbstractAsset {

    /**
     * @inheritdoc
     */
    protected $plugin_css = [
        'css/core.min.css',
        'css/jquery.min.css',
        'css/bootstrap.min.css',
        'css/theme.min.css',
        'css/pages.min.css'
    ];

    protected $plugin_js = [
        'scripts/plugins.core.min.js',
        'scripts/app.min.js',
        'scripts/bootstrap.plugins.min.js',
        'scripts/jquery.plugins.min.js',
        'scripts/extend.min.js',
    ];

    /**
     * @inheritdoc
     */
    protected $plugin_depends = [
        'liuxy\admin\assets\IE9Asset'
    ];
}
