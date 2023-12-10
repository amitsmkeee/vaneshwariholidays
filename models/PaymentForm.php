<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class PaymentForm extends Model
{
    public $merchantTransactionId;

    public $merchantUserId;
  
    public float $amount;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // merchantTransactionId, merchantUserId and amount are both required
            [['merchantTransactionId', 'merchantUserId', 'amount'], 'required'],
        ];
    }
    
}
