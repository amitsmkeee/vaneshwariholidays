<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Transaction $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="transaction-view">

    <p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'amount',
            'merchantUserId',
        ],
    ]) ?>

</div>
