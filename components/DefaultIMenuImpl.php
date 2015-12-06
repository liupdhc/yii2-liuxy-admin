<?php
namespace liuxy\admin\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\VarDumper;
use liuxy\admin\models\Permission;

/**
 * 默认基于数据库实现IMenu接口，继承该类时，必须实现以下方法：
 * getParentsCondition
 * 可选实现的方法：
 * getLimit（默认支持3级菜单）
 * findTop
 * getCheckedIdentity
 * clearCache
 * 必须覆盖的常量：
 * CACHE_SUB
 *
 * FileName: DefaultIMenuImpl.php.
 * Author: liupeng
 * Date: 2015/8/11
 */
abstract class DefaultIMenuImpl extends \yii\liuxy\ActiveRecord implements \liuxy\admin\models\intr\IMenu {

    const CACHE_SUB = 'default.subs';
    const MAX_LEVEL = 3;

    /**
     * 返回获取子菜单所需的查询条件数组
     * @param int $parentId 父级标识
     * @return array
     */
    public static function getParentsCondition($parentId) {
        return ['parent_id'=>$parentId];
    }

    /**
     * @inheritDoc
     */
    public static function findTop($menu) {
        // TODO: Implement findTop() method.
        throw new \yii\base\NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritDoc
     */
    public static function getSub($parentId, $filter = []) {
        // TODO: Implement getSub() method.
        $items = self::getCache()->get(static::CACHE_SUB . $parentId);
        if (!$items) {
            $items = self::findAllArray(static::getParentsCondition($parentId));
            if ($items) {
                self::getCache()->set(static::CACHE_SUB . $parentId, $items);
            } else {
                self::getCache()->set(static::CACHE_SUB . $parentId, []);
            }
        }

        if ($filter) {
            $ret = [];
            foreach($items as $item) {
                if (in_array($item[static::$pk], $filter)) {
                    $ret[] = $item;
                }
            }
            return $ret;
        }
        return $items;
    }

    /**
     * @inheritDoc
     */
    public static function getAllSub($parentId = 0, $filter = []) {
        // TODO: Implement getAllSub() method.
        $category = self::findeByCache($parentId);
        if ($category) {
            $subItems = static::getSub($category[static::$pk], $filter);
            if ($subItems) {
                self::recursion($subItems, $filter);
                $category['sub'] = $subItems;
            }
        }
        return $category;
    }

    /**
     * @inheritDoc
     */
    public static function getLimit() {
        // TODO: Implement getLimit() method.
        return static::MAX_LEVEL;
    }

    /**
     * @inheritDoc
     */
    public static function generatorTree($data) {
        // TODO: Implement generatorTree() method.
        $tree = [ ];

        foreach ( $data as $item ) {
            if (isset ( $data [$item ['pid']] )) {
                $data [$item ['pid']] ['sub'] [] = &$data [$item [static::$pk]];
            } else {
                $tree [] = &$data [$item [static::$pk]];
            }
        }

        return $tree;
    }

    /**
     * @inheritDoc
     */
    public static function setChecked(&$menus, $mappingItems) {
        // TODO: Implement setChecked() method.
        if ($mappingItems) {
            $returnIds = [];
            foreach ($mappingItems as $item) {
                if (!in_array($item[static::getCheckedIdentity()], $returnIds)) {
                    $returnIds[] = 'node_' . $item[static::getCheckedIdentity()];
                }
            }
            foreach ($menus as &$item) {
                if (in_array($item[static::$pk], $returnIds)) {
                    $item['state']['selected'] = true;
                } else {
                    $item['state']['selected'] = false;
                }
            }
        }
    }

    /**
     * 获取setChecked方法调用时，用于查找存在性的索引标识
     * @return string
     */
    public static function getCheckedIdentity() {
        return static::$pk;
    }

    /**
     * 重写插入函数，清理必要的缓存数据
     *
     * @param bool $runValidation
     * @param null $attributes
     * @return bool|void
     */
    public function insert($runValidation = true, $attributes = null) {
        $ret = parent::insert($runValidation, $attributes);
        if ($ret) {
            static::clearCache($this);
            if ($this->parent_id) {
                $parent = self::findOne(['id'=>$this->parent_id]);
                if ($parent) {
                    $parent->is_leaf = Permission::LEAF_NO;
                    $parent->update();
                    if ($parent->hasErrors()) {
                        $this->addErrors($parent->getErrors());
                        return false;
                    }
                }
            }
        }
        return $ret;
    }

    /**
     * 重写更新函数，清理必要的缓存数据
     *
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool|int|void
     */
    public function update($runValidation = true, $attributeNames = null) {
        $ret = parent::update($runValidation, $attributeNames);
        if ($ret) {
            static::clearCache($this);
        }
        return $ret;
    }

    /**
     * 重写更新记录，清除主键缓存
     *
     * @param array  $attributes
     * @param string $condition
     * @param array  $params
     * @return int
     * @throws Exception
     */
    public static function updateAll($attributes, $condition = [], $params = []) {
        $ret = parent::updateAll($attributes, $condition, $params);
        if ($ret && is_array($condition)) {
            if (self::allowFromCache($condition)) {
                $item = self::findOne([static::$pk => $condition[static::$pk]]);
                if ($item) {
                    static::clearCache($item);
                }
            }
        }
        return $ret;
    }

    /**
     * 删除菜单，同时递归删除子菜单
     *
     * @param $id
     */
    public static function remove($id) {
        $subs = static::getSub($id);
        if ($subs) {
            foreach ($subs as $sub) {
                self::remove($sub[static::$pk]);
            }
        }

        $item = self::findOne([static::$pk => $id]);
        $ret = self::deleteAll([static::$pk => $id]);
        if ($ret) {
            static::clearCache($item);
            /**
             * 监测父级是否还有子列表
             */
            if ($item->parent_id) {

                $parent = self::findOne(['id' => $item->parent_id]);
                if ($parent) {

                    $subs = static::getSub($parent->id);
                    if (!$subs) {
                        $parent->is_leaf = Permission::LEAF_YES;
                        $parent->update();
                        if ($parent->hasErrors()) {
                            Yii::error(VarDumper::dumpAsString($parent->getErrors()), __METHOD__);
                            return false;
                        }
                        unset($subs);
                    }
                }
                unset($parent);
            }
        }
        unset($item);
        return $ret;
    }

    /**
     * 清理缓存
     * @param $item
     */
    public static function clearCache($item) {
        self::getCache()->delete(static::CACHE_SUB . $item->parent_id);
    }

    /**
     * 递归获取子列表
     * @param $subItems
     * @param $filter
     */
    protected static function recursion(&$subItems, $filter = []) {
        foreach ($subItems as &$item) {
            $sub= self::getSub($item[static::$pk], $filter);
            if ($sub) {
                self::recursion($sub);
                $item['sub'] = $sub;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public static function generatorSelect(&$data) {
        // TODO: Implement generatorSelect() method.
        foreach($data as &$item) {
            if (!isset($item['level'])) {
                throw new InvalidConfigException('item must be contain `level` attribute');
            }
            if (!isset($item['name'])) {
                throw new InvalidConfigException('item must be contain `name` attribute');
            }
            $level = intval($item['level']);
            $item['selectStr'] = '|';
            for($i = 0; $i < $level; $i++) {
                $item['selectStr'].='--';
            }
            $item['selectStr'] .= $item['name'];
        }
    }


    /**
     * 获取默认顶级类目
     */
    public static function getDefault() {
        return [[
            "id" => "node_0",
            "text" => "顶级类目",
            "state" => ['opened'=>true],
            "icon" => "fa fa-folder icon-lg",
            "children" => true,
            "type" => "root"
        ]];
    }
}