<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

/** @var yii\web\View $this */
/** @var app\models\Invoice $model */
?>
<?php $this->registerJS("
			$(document).on('click', '.close', function(event)
			{
				$(event.target).parents('div.InvoiceItem').remove();
			});

            $(document).on('click', '#add-invoice-btn', function(event) {
                $.ajax({
                    type: 'POST',
                    url: '".Url::to(['invoice/add-section'])."',
                    data: $('#invoice-form').serialize(),
                    success: function(resultData) { 
                        $('#section-list').append(resultData);
                     },
                     error: function(message) {
                        alert(message.responseText);
                     }
              });
              return false;
            });
			", View::POS_READY, 'invoice-section');
?>

<section class="content" style="padding-top: 0px !important;">
    <?php $form = ActiveForm::begin(['id' => 'invoice-form', 'layout'=>'horizontal']); ?>

    <div class="invoice-form row" >
        <div class="col-md-6">
            <?= $form->field($model, 'invoiceId')->textInput(['readonly' => true])->label("Invoice Id") ?>
            <?= $form->field($model, 'date', ['inputOptions' => ['style' => 'width:100%', 'type' => 'date', 'class' => 'form-control']]) ?>
            <?= $form->field($model, 'buyerName')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'buyerAddress')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom:10px" id="section-list">
            <h3 class="title-box"> Sections : </h3>
            <?php
				$count = 0;
				foreach ($sections as $section)
				{
				    echo $this->render('_addSection', array(
					        'model' => $section,
							'count' => $count++,
                            'form' => $form ,
                            'create' => false,
					));
				}
			?>
        </div>

        <div class="form-actions row" style="padding-left: 20px;">
            <div class="form-group">
                <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update',['class' => 'btn btn-success']); ?>
                <?php echo Html::button('Add Invoice Item',['class' => 'btn btn-success', 'id' => 'add-invoice-btn']); ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</section>
