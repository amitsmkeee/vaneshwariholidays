<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoiceItem".
 *
 * @property int $id
 * @property int $siNo
 * @property int $invoiceId
 * @property string $name
 * @property string $hsn
 * @property float $amount
 */
class InvoiceItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoiceItem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siNo', 'invoiceId', 'name', 'hsn', 'amount'], 'required'],
            [['siNo', 'invoiceId'], 'integer'],
            [['amount'], 'number'],
            [['name', 'hsn'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'siNo' => 'Si No',
            'invoiceId' => 'Invoice ID',
            'name' => 'Name',
            'hsn' => 'Hsn',
            'amount' => 'Amount',
        ];
    }
}
