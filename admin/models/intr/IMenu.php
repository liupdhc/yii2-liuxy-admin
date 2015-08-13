<?php
/**
 * Author: liupeng
 * Date: 2015/7/11
 */
namespace liuxy\admin\models\intr;
/**
 * 抽象菜单接口操作
 * Interface IMenu
 */
interface IMenu {
    /**
     * 获取下级子菜单列表
     * @param integer   $parentId 父级ID
     * @param array $filter 需要过滤的数组
     * @return mixed
     */
    public static function getSub($parentId, $filter = []);

    /**
     * 获取所有子菜单列表
     * @param integer   $parentId   父级ID
     * @param array $filter 需要过滤的数组
     * @return mixed
     */
    public static function getAllSub($parentId, $filter = []);

    /**
     * 获取支持最大的子菜单数
     * @return integer
     */
    public static function getLimit();

    /**
     * 获取顶级父菜单
     * @param $menu 菜单对象
     * @return mixed
     */
    public static function findTop($menu);

    /**
     * 生成前端使用的子列表对应的树形结构数据
     * @param array $data   菜单数据
     * @return array  树形结构数据
     */
    public static function generatorTree($data);

    /**
     * 设置菜单选中
     * @param array $menus    菜单列表
     * @param array $mappingItems 需要设置选中的菜单对应关系数组
     * @return void
     */
    public static function setChecked(&$menus, $mappingItems);
}