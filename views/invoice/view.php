<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Invoice $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="invoice-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Download', ['download', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'invoiceId',
            'buyerName',
            'buyerAddress',
            'date',
            'gst',
            'buyerState',
            'buyerStateCode',
            'gstIN',
            'totalAmount'
        ],
    ]) ?>

<?= GridView::widget([
        'dataProvider' => $dataProviderInvoiceItems,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'siNo',
            'hsn',
            'invoiceId',
            'name',
            'amount',   
        ],
    ]); ?>
<?php
    if (strtolower($model->buyerState) == "tamilnadu") {
        echo "<p style='color: #0288ae;font-size: 16px; bold;'>CGST: " . Html::label(($model->gst/2 * 0.01) * $sumAmount) . "</p>";
        echo "<p style='color: #0288ae;font-size: 16px; bold;'>SGST: " . Html::label(($model->gst/2 * 0.01) * $sumAmount) . "</p>";
    } else {
        echo "<p style='color: #0288ae;font-size: 16px; bold;'>IGST: " . Html::label($model->gst * 0.01 * $sumAmount) . "</p>";
    }
?>
<p style='color: #0288ae;font-size: 16px; bold;'>Total Amount: <?= Html::encode($model->totalAmount) ?></p>    
</div>
