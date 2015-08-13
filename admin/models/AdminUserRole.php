<?php

namespace liuxy\admin\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "admin_user_role".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $role_id
 * @property integer $insert_time
 * @property string $insert_by
 */
class AdminUserRole extends \yii\liuxy\ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'admin_user_role';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'role_id'], 'required'],
            [['user_id', 'role_id', 'insert_time'], 'integer'],
            [['insert_by'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'role_id' => '角色ID',
            'insert_time' => '插入时间',
            'insert_by' => '添加者',
        ];
    }

    /**
     * 管理员与角色绑定管理
     * @param $userId
     * @param $roleIds
     * @param $loginUser \liuxy\admin\models\AdminUser
     * @throws \Exception
     */
    public static function bind($userId, $roleIds, $loginUser) {
        self::deteteAll(['user_id' => $userId]);

        if (!empty($roleIds)) {
            foreach ($roleIds as $rid) {
                if (!empty($rid)) {
                    $item = new AdminUserRole();
                    $item->isNewRecord = true;
                    $item->user_id = $userId;
                    $item->role_id = $rid;
                    $item->insert_by = $loginUser->insert_by;
                    $item->insert();
                    if ($item->hasErrors()) {
                        Yii::error(VarDumper::dumpAsString($item->getErrors()), __METHOD__);
                    }
                    unset($item);
                }
            }
        }
    }
}
