<?php
/**
 * Copyright 2008-2015 OPPO Mobile Comm Corp., Ltd, All rights reserved.
 *
 * FileName: Wysihtml5Asset.php
 * Author: liupeng
 * Date: 1/11/16
 */

namespace liuxy\admin\assets\plugins;

/**
 * 富文本编辑器插件
 * Class CkEditorAsset
 * @package liuxy\admin\assets\plugins
 */
class CkEditorAsset extends PluginsAsset {

    protected $plugin_js = [
        'plugins/ckeditor/ckeditor.js',
        'plugins/ckeditor/bootstrap-ckeditor-modal-fix.js',
    ];
}