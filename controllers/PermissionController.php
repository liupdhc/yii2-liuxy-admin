<?php
/**
 * FileName: PermissionController.php.
 * Author: liupeng
 * Date: 2015/7/01
 */

namespace liuxy\admin\controllers;
use liuxy\admin\models\JSTreeGenerator;
use liuxy\admin\models\Permission;
use liuxy\admin\Module;

/**
 * 权限控制类
 * Class PermissionController
 * @package liuxy\admin\controllers
 */
class PermissionController extends \liuxy\admin\components\Controller {

    /**
     * 权限管理页
     */
    public function actionIndex() {
        $this->setResponseData(['breads'=>[
            ['name'=>Module::t( 'perm.title')]
        ]]);
    }

    /**
     * 根据子节点
     */
    public function actionAjax() {
        $this->layout = false;
        $data = [];
        $parentId = $this->get('parent', '#');
        $id = 1;
        $generator = new JSTreeGenerator();
        if ($parentId != '#') {
            $len = strlen('node_');
            $id = substr($parentId, $len, strlen($parentId)-$len);
            $data = $generator->generator(Permission::getSub($id));
        } else {
            $data = $generator->getDefault();
        }
        $this->setResponseData('item',Permission::findeByCache($id));

        $this->setResponseData('data',$data);
    }

    /**
     * 添加子节点
     */
    public function actionCreate() {
        $parentId = $this->get('parent_id', 1);
        $parent = Permission::findeByCache($parentId);
        if ($parent) {
            if ($parent['level'] >= Permission::getLimit()) {
                $this->setError(Module::t('error.perm.level.max'));
            } else {
                /**
                 * @var $perm \liuxy\admin\models\Permission
                 */
                $perm = new Permission();
                if ($perm->load($this->request)) {
                    $perm->is_leaf = Permission::LEAF_YES;
                    $perm->editable = 1;
                    $perm->status = Permission::STATUS_OK;
                    $perm->level = intval($parent['level']) + 1;
                    $perm->seq = 0;
                    $perm->insert_by = $this->user->username;
                    if (!$perm->insert()) {
                        $this->setError($perm->getErrors());
                    } else {
                        $this->setResponseData('data',['name'=>$perm->name,'id'=>$perm->id]);
                    }
                } else {
                    $this->setError(Module::t('error.load.data'));
                }
            }
        } else {
            $this->setError(Module::t('error.perm.parent.notexists'));
        }
    }

    /**
     * 获取权限
     * @return string|void
     */
    public function actionGet() {
        $id = $this->get('id', 0);
        if ($id) {
            $perm = Permission::findeByCache($id);
            if ($perm) {
                $this->setResponseData('data',$perm);
            } else {
                $this->setError(Module::t('error.perm.notexists'));
            }
        } else {
            $this->setError(Module::t('error.perm.notexists'));
        }
    }

    /**
     * 更新权限
     */
    public function actionUpdate() {
        $id = $this->get('parent_id', 0);//parent_id为实际编辑的id
        /**
         * @var $perm \liuxy\admin\models\Permission
         */
        $perm = Permission::findOne([Permission::$pk=>$id]);
        if ($perm) {
            if ($perm->editable == 1) {
                $perm->name = $this->get('name', '');
                $perm->description = $this->get('description', '');
                $perm->link = $this->get('link', '');
                $perm->icon = $this->get('icon', '');
                $perm->is_nav = $this->get('is_nav', Permission::NAV_NO);
                $perm->update_by = $this->user->username;
                if (!$perm->update()) {
                    $this->setError($perm->getErrors());
                }
                $this->setResponseData('data',['name'=>$perm->name,'id'=>$perm->id]);
            } else {
                $this->setError(Module::t('error.perm.noeditable'));
            }

        } else {
            $this->setError(Module::t('error.perm.notexists'));
        }
    }

    /**
     * 删除权限
     */
    public function actionDelete() {
        $id = $this->get('id', 0);
        if ($id == 1) {
            $this->setError(Module::t('error.perm.root.delete'));
        } else {
            $ret = Permission::remove($id);
            if (!$ret) {
                $this->setError(Module::t('error.delete'));
            }
        }

    }

    /**
     * 更新序号
     */
    public function actionSeq() {
        $ids = explode('_', $this->get ( 'ids', '' ));
        $seq = 0;
        foreach($ids as $id) {
            if ($id != '') {
                Permission::updateAll(['seq'=>$seq],['id'=>$id]);
                $seq++;
            }
        }
    }

}