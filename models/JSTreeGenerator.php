<?php
/**
 * Author: liupeng
 * Date: 2015/7/11
 */

namespace liuxy\admin\models;

use liuxy\admin\models\intr\IGeneratorTree;

/**
 * 使用jquery.jstree插件的菜单生成器
 * Class JSTreeGenerator
 *
 * @package liuxy\admin\models
 */
class JSTreeGenerator implements IGeneratorTree {
    /**
     * @inheritDoc
     */
    public function generator($menus, $opened = false) {
        // TODO: Implement generator() method.
        $data = [];
        foreach ($menus as $p) {
            $children = $p['is_leaf'] == Permission::LEAF_NO?true:false;
            $data[] = [
                'id'=>"node_".$p['id'],
                'pid'=>$p['parent_id'],
                'text'=>$p['name'],
                "state" => ['opened'=>$opened ? true : false],
                'children'=>$children,
                'icon'=> ($children ? 'fa fa-folder icon-lg icon-state-success':'fa fa-file icon-lg icon-state-warning')
            ];
        }
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function getDefault() {
        // TODO: Implement getDefault() method.
        return [[
            "id" => "node_1",
            "text" => "顶级权限",
            "state" => ['opened'=>true],
            "icon" => "fa fa-folder icon-lg",
            "children" => true,
            "type" => "root"
        ]];
    }

}