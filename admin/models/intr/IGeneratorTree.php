<?php
/**
 * Author: liupeng
 * Date: 2015/7/11
 */

namespace liuxy\admin\models\intr;

interface IGeneratorTree {

    /**
     * 生成适用于前端使用的数据
     * @param            $menus 菜单列表
     * @param bool|false $opened    是否默认展开
     * @return mixed
     */
    public function generator($menus, $opened = false);

    /**
     * 获取默认的顶级菜单
     * @return mixed
     */
    public function getDefault();
}