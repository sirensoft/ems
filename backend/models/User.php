<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ems_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property string $role
 * @property string $fullname
 * @property string $officer
 * @property string $hospcode
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $last_login
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ems_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email', 'role'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'role', 'fullname', 'officer', 'last_login'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['hospcode'], 'string', 'max' => 5],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'role' => 'สิทธิการใช้',
            'fullname' => 'ชื่อ-นามสกุล',
            'officer' => 'ตำแหน่ง',
            'hospcode' => 'รหัสหน่วยบริการ',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'last_login' => 'Last Login',
        ];
    }
}
