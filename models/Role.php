<?php

namespace liuxy\admin\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property integer $insert_time
 * @property string $insert_by
 * @property string $update_by
 * @property integer $update_time
 */
class Role extends \yii\liuxy\ActiveRecord {

    public static $pk = 'id';
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'description'], 'required'],
            [['status', 'insert_time', 'update_time'], 'integer'],
            [['name', 'insert_by', 'update_by'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 100],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => '角色名',
            'description' => '角色描述',
            'status' => '(1)ok,(0)disable',
            'insert_time' => '插入时间',
            'insert_by' => '添加者',
            'update_by' => '最后更新者',
            'update_time' => '最后更新时间',
        ];
    }
}
