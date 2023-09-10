<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\InvoiceSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'invoiceId') ?>

    <?= $form->field($model, 'buyerName') ?>

    <?= $form->field($model, 'buyerAddress') ?>

    <?= $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'companyId') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'sgst') ?>

    <?php // echo $form->field($model, 'cgst') ?>

    <?php // echo $form->field($model, 'totalAmount') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
