<?php

namespace app\models;
use Yii;

class UserIdentity extends User implements \yii\web\IdentityInterface
{
    public $authKey;
    public $accessToken;

    /**
     * {@inheritdoc}
     */

     public static function tableName()
     {
         return parent::tableName();
     }

    public static function findByUsername($username)
    {
        return UserIdentity::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->userId;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        // echo $password;
        // echo $this->password;
        // die;
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }


     public static function findIdentity($id)
     {
         return UserIdentity::findOne($id);
     }

     /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return $token;
    }
}
