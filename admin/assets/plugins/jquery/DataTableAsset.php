<?php
/**
 * Created by liupeng.
 * Date: 2015/6/30
 * File: DataTableAsset.php
 */

namespace liuxy\admin\assets\plugins\jquery;

use liuxy\admin\assets\plugins\PluginsAsset;

class DataTableAsset extends PluginsAsset {
    protected $plugin_css = [
        'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.min.css'
    ];

    protected $plugin_js = [
        'plugins/datatables/media/js/jquery.dataTables.min.js',
        'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.min.js'
    ];
} 