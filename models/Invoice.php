<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property int|null $invoiceId
 * @property string|null $buyerName
 * @property string|null $buyerAddress
 * @property string|null $date
 * @property int|null $companyId
 * @property float|null $sgst
 * @property float|null $cgst
 * @property float|null $totalAmount
 * @property int $cBy
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoiceId', 'companyId', 'cBy'], 'integer'],
            [['date'], 'safe'],
            [['sgst', 'cgst', 'totalAmount'], 'number'],
            [['cBy'], 'required'],
            [['buyerName', 'buyerAddress'], 'string', 'max' => 255],
            [['invoiceId', 'companyId'], 'unique', 'targetAttribute' => ['invoiceId', 'companyId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoiceId' => 'Invoice ID',
            'buyerName' => 'Buyer Name',
            'buyerAddress' => 'Buyer Address',
            'date' => 'Date',
            'companyId' => 'Company ID',
            'sgst' => 'Sgst',
            'cgst' => 'Cgst',
            'totalAmount' => 'Total Amount',
            'cBy' => 'C By',
        ];
    }
}
