<?php
/**
 * Copyright 2008-2015 OPPO Mobile Comm Corp., Ltd, All rights reserved.
 *
 * FileName: FileUploadAsset.php
 * Author: liupeng
 * Date: 10/12/15
 */

namespace liuxy\admin\assets\plugins\jquery;


use liuxy\admin\assets\plugins\PluginsAsset;

class FileUploadAsset extends PluginsAsset {
    protected $plugin_css = [
        'plugins/jquery-file-upload/css/jquery.fileupload.all.min.css',

    ];

    protected $plugin_js = [
        'plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js',
        'plugins/jquery-file-upload/js/jquery.iframe-transport.js',
        'plugins/jquery-file-upload/js/jquery.fileupload.js'
    ];
}