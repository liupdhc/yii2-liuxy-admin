<?php

namespace liuxy\admin\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "role_permission".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $permission_id
 * @property integer $insert_time
 * @property string $insert_by
 */
class RolePermission extends \yii\liuxy\ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'role_permission';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['role_id', 'permission_id'], 'required'],
            [['role_id', 'permission_id', 'insert_time'], 'integer'],
            [['insert_by'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role_id' => '角色ID',
            'permission_id' => '权限ID',
            'insert_time' => '插入时间',
            'insert_by' => '添加者',
        ];
    }

    /**
     * 绑定角色与权限的对应关系
     * @param $roleId   角色ID
     * @param $pids 权限ID列表
     * @param $loginUser \liuxy\admin\models\AdminUser
     */
    public static function bind($roleId, $pids,$loginUser) {
        self::deteteAll(['role_id' => $roleId]);
        if (!empty($pids)) {
            $pids = explode(',',$pids);
            $pids = array_unique($pids);
            foreach ($pids as $pid) {
                if (!empty($pid)) {
                    $item = new RolePermission();
                    $item->isNewRecord = true;
                    $item->role_id = $roleId;
                    $item->permission_id = $pid;
                    $item->insert_by = $loginUser->username;
                    $item->insert();
                    if ($item->hasErrors()) {
                        Yii::error(VarDumper::dumpAsString($item->getErrors()), __METHOD__);
                    }
                    unset($item);
                }
            }
            /**
             * 清理角色下所对应用户的权限
             */
            foreach (AdminUserRole::find()->where(['role_id'=>$roleId])->all() as $userRole) {
                AdminUser::clearPermission($userRole['user_id']);
            }
        }
    }
}
