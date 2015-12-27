<?php
/**
 * FileName: RoleController.php.
 * Author: liupeng
 * Date: 2015/7/01
 */

namespace liuxy\admin\controllers;

use liuxy\admin\models\Role;
use liuxy\admin\models\Permission;
use liuxy\admin\models\RolePermission;
use liuxy\admin\models\JSTreeGenerator;
use liuxy\admin\Module;

/**
 * 控制角色类
 * Class RoleController
 *
 * @package liuxy\admin\controllers
 */
class RoleController extends \liuxy\admin\components\Controller {

    /**
     * 角色列表页
     */
    public function actionIndex() {
        $this->setResponseData(['breads'=>[
            ['name'=>Module::t( 'role.title')]
        ]]);
        $roles = Role::findAllArray(['status'=>Role::STATUS_OK]);
        $this->setResponseData('data',['items'=>$roles]);
    }

    /**
     * 创建角色
     */
    public function actionSave() {
        $id = $this->get('id','');
        if (empty($id)) {
            //添加
            /**
             * @var $role \liuxy\admin\models\Role
             */
            $role = new Role();
            if ($role->load($this->request)) {
                $role->status = Role::STATUS_OK;
                if (empty($role->description)) {
                    $role->description = $role->name;
                }
                $role->insert_by = $this->user->username;
                if (!$role->insert()) {
                    $this->setError($role->getErrors());
                } else {
                    $this->setResponseData('data',['name'=>$role->name,'id'=>$role->id]);
                }
            } else {
                $this->setError(Module::t('error.load.data'));
            }
        } else {
            //更新
            /**
             * @var $role \liuxy\admin\models\Role
             */
            $role = Role::findOne(['id'=>$id]);
            if ($role) {
                $role->name = $this->get('name', '');
                $role->description = $this->get('description', $role->name);
                if (!$role->update()) {
                    $this->setError($role->getErrors());
                } else {
                    //更新角色与权限对应关系
                    RolePermission::bind($id, $this->get('pids',''), $this->user);
                }
            } else {
                $this->setError(Module::t('error.role.notexists'));
            }
        }
    }

    /**
     * 获取角色信息
     */
    public function actionGet() {
        $id = $this->get('id',0);
        $role = Role::findByCache($id);
        $this->setResponseData('data',$role);
    }

    /**
     * 删除角色
     */
    public function actionDelete() {
        $id = $this->get('id',0);
        $role = Role::findByCache($id);
        if ($role) {
            if ($role['id'] == 1) {
                $this->setError(Module::t('error.role.power.edit'));
            } else {
                Role::deleteAll(['id'=>$id]);
                RolePermission::deleteAll(['role_id'=>$id]);
            }
        } else {
            $this->setError(Module::t('error.role.notexists'));
        }
    }

    /**
     * 获取角色对应的权限列表
     */
    public function actionPerm() {
        $data = [];
        $parentId = $this->get('parent', '#');
        $roleId = $this->get('id', 0);

        $generator = new JSTreeGenerator();
        if ($parentId != '#') {
            $len = strlen('node_');
            $id = substr($parentId, $len, strlen($parentId)-$len);
            $data = $generator->generator(Permission::getSub($id), true);
        } else {
            $data = $generator->getDefault();
        }

        if (!empty($roleId)) {
            $roles = RolePermission::findAllArray(['role_id'=>$roleId]);
            Permission::setChecked($data, $roles);
        }

        $this->setResponseData('data',$data);
    }
}
