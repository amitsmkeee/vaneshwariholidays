<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Account;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class ChangePasswordForm extends Model
{
    public $currentPassword;

    public $newPassword;
  
    public $newPasswordRepeat;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            // password is validated by validatePassword()
            ['currentPassword', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if(!$user) {
                $this->addError($attribute, 'User not found');
            }
            if (!$user->validatePassword($this->currentPassword)) {
                $this->addError($attribute, 'Incorrect username or password.');
            } else if (strcmp($this->newPassword ,$this->currentPassword) == 0){
                $this->addError($attribute, 'Old Password is same as new Password');
            } else if (strcmp($this->newPassword , $this->newPasswordRepeat ) != 0) {
                $this->addError($attribute, 'new password and repeat password are not same');
            }
        }
    }

    public function changePassword() 
    {
        if ($this->validate()) {
            $this->_user->password = Yii::$app->getSecurity()->generatePasswordHash($this->newPassword);
            if( $this->_user->save(false)) {
                return true;
            }
        }
        return false;
    }

    public function getUser()
    {
        // print_r($this->_user);
        if ($this->_user === false) {
            //  print_r($this->_user);
            $this->_user = UserIdentity::findByUsername(Yii::$app->user->identity->username);
            //  print_r($this->_user);
        }
        //  exit;
        return $this->_user;
    }

    
}
