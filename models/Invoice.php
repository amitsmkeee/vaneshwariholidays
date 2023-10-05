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
 * @property float|null $gst
 * @property float|null $totalAmount
 * @property int $cBy
 * @property string $gstIN
 * @property string $buyerState
 * @property int $buyerStateCode
 * @property float $serviceCharge
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
            [['invoiceId', 'companyId', 'cBy', 'buyerStateCode'], 'integer'],
            [['date'], 'safe'],
            [['gst', 'totalAmount', 'serviceCharge'], 'number'],
            [['cBy', 'gstIN', 'buyerState', 'buyerStateCode'], 'required'],
            [['buyerName', 'buyerAddress'], 'string', 'max' => 255],
            [['gstIN'], 'string', 'max' => 20],
            [['buyerState'], 'string', 'max' => 30],
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
            'gst' => 'Gst',
            'totalAmount' => 'Total Amount',
            'cBy' => 'C By',
            'gstIN' => 'Gst In',
            'buyerState' => 'Buyer State',
            'buyerStateCode' => 'Buyer State Code',
            'serviceCharge' => 'Service Charge',
        ];
    }
}
