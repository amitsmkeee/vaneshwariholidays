<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $companyId
 * @property float $amount
 * @property string $merchantUserId
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['companyId', 'amount', 'merchantUserId'], 'required'],
            [['companyId'], 'integer'],
            [['amount'], 'number'],
            [['merchantUserId'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'companyId' => 'Company ID',
            'amount' => 'Amount',
            'merchantUserId' => 'Merchant User ID',
        ];
    }
}
