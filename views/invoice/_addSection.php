<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\View;
/** @var yii\widgets\ActiveForm $form */

?>

<div class="InvoiceItem" style="border: thin solid #000000;margin:10px;">
    <div class="InvoiceItem_inner" style="margin:10px;">
        <p class="title-box">
            Invoice Item #<?php echo ($count + 1)?>
            <?php echo Html::button("X", array('style'=>'float:right;color:red;', 'class' => 'close')); ?>
        </p>

        <?php 
        if($create)
			  $form = new ActiveForm(['layout' => 'horizontal']);
        ?>
        
        <div class="InvoiceItemcontent row">
            <div class="col-md-6">
                <?= $form->field($model, '['.$count.']name')->textInput(['maxlength' => true])->label('Item Name')  ?>
                <?= $form->field($model, '['.$count.']hsn')->textInput(['maxlength' => true])->label('HSN') ?>
                <?= $form->field($model,  '['.$count.']amount')->textInput(['maxlength' => true])->label('Amount') ?>
            </div>
        </div>
    </div>
</div>