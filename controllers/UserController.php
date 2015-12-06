<?php
/**
 * FileName: UserController.php.
 * Author: liupeng
 * Date: 2015/7/10
 */

namespace liuxy\admin\controllers;
use liuxy\admin\components\Controller;
use liuxy\admin\models\AdminUser;
use liuxy\admin\models\AdminUserRole;
use liuxy\admin\models\Role;
use liuxy\admin\Module;

/**
 * 管理员控制类
 * Class UserController
 *
 * @package liuxy\admin\controllers
 */
class UserController extends Controller {

    /**
     * 管理员列表页面
     */
    public function actionIndex() {
        $this->setResponseData(['breads'=>[
            ['name'=>Module::t( 'user.title')]
        ]]);
        $status = $this->get('status', AdminUser::STATUS_OK);
        $userList = AdminUser::findAllArray(['status'=>$status]);
        $roles = Role::findAllArray(['status'=>Role::STATUS_OK]);
        $returnRoles = [];
        if ($roles) {
            foreach($roles as $role) {
                $returnRoles[$role['id']] = $role['name'];
            }
        }
        $this->setResponseData('data',['items'=>$userList,'roles'=>$returnRoles,
            'opt'=>['status'=>$status],
            'status'=>[
                AdminUser::STATUS_OK=>Module::t('status.ok'),
                AdminUser::STATUS_NO=>Module::t('status.no')
            ]]);
    }

    /**
     * 添加或更新管理员信息
     * @throws \Exception
     */
    public function actionSave() {
        $id = $this->get('id','');
        if (empty($id)) {
            //添加
            /**
             * @var $user \liuxy\admin\models\AdminUser
             */
            $user = new AdminUser();
            if ($user->load($this->request)) {
                $user->trd_identifier = $this->get('trd_identifier','');
                $user->status = AdminUser::STATUS_OK;
                $user->password_prefix = md5(uniqid(mt_rand(), true));
                $user->password = md5($user->password_prefix.$user->password);
                $user->insert_by = $this->user->username;
                if (!$user->insert()) {
                    $this->setError($user->getErrors());
                } else {
                    /**
                     * 增加管理员与角色的对应管理
                     */
                    $roles = $this->get('role',[]);
                    AdminUserRole::bind($user->id, $roles, $this->user);
                    $this->setResponseData('data',['username'=>$user->username,'id'=>$user->id]);
                }
            } else {
                $this->setError(Module::t('error.load.data'));
            }
        } else {
            //更新
            /**
             * @var $user \liuxy\admin\models\AdminUser
             */
            $user = AdminUser::findOne(['id'=>$id]);
            if ($user) {
                $user->name = $this->get('name', '');
                $user->trd_identifier = $this->get('trd_identifier','');
                if ($user->username === 'admin' && $this->user->id !== $user->id) {
                    $this->setError(Module::t('error.admin.onlyedit'));
                    return false;
                }
                $user->status = $this->get('status', AdminUser::STATUS_OK);
                if ($user->status === AdminUser::STATUS_NO && $user->username === 'admin') {
                    $this->setError(Module::t('error.admin.disabled'));
                    return false;
                }
                $password = $this->get('password','');
                if ($password != md5('')) {
                    $user->password_prefix = md5(uniqid(mt_rand(), true));
                    $user->password = md5($user->password_prefix.$password);
                }

                if (!$user->update()) {
                    $this->setError($user->getErrors());
                } else {
                    //更新用户与角色对应关系
                    $roles = $this->get('role',[]);
                    AdminUserRole::bind($user->id, $roles, $this->user);
                }
            } else {
                $this->setError(Module::t('error.user.notexists'));
            }
        }
    }

    /**
     * 获取管理员信息
     */
    public function actionGet() {
        $id = $this->get('id', 0);
        $user = AdminUser::findeByCache($id);
        if ($user) {
            $roles = AdminUserRole::findAllArray(['user_id'=>$id]);
            if ($roles) {
                $user['roles'] = $roles;
            }
            $this->setResponseData('data', $user);
        } else {
            $this->setError(Module::t('error.user.notexists'));
        }
    }
}