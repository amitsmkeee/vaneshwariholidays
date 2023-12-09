<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $userId
 * @property string $username
 * @property string $email
 * @property string $password
 * @property int $companyId
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'companyId'], 'required'],
            [['companyId'], 'integer'],
            [['username', 'email', 'password'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'companyId' => 'Company ID',
        ];
    }
}
