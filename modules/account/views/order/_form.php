<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">

    <?php Pjax::begin([
        'id' => 'form-order-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]) ?>
        <?php $form = ActiveForm::begin([
            'id' => 'form-order',
            'options' => [
                'data-pjax' => true,
            ]
        ]); ?>

        <div class="d-flex col-4 justify-content-between">
            <?= $form->field($model, 'date_order')->textInput(['type' => 'date', 'min' => date('Y-m-d')]) ?>
        
            <?= $form->field($model, 'time_order')->textInput(['type' => 'time', 'min' => '09:00', 'max' => '20:00']) ?>
        </div>


        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'pay_type_id')->textInput()->dropDownList($payTypes, ['prompt' => 'Выберите способ оплаты']) ?>

        <?= $form->field($model, 'outpost_id')->textInput()->dropDownList($outposts, ['prompt' => 'Выберите пункт выдачи', 'disabled' => $model->check]) ?> 

        <?= $form->field($model, 'check')->checkbox()->label('Другое место получения заказа') ?>
        
        <?= $form->field($model, 'comment')->textInput(['maxlength' => true, 'disabled' => ! $model->check]) ?> 


        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-outline-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    <?php Pjax::end() ?>
</div>

<?php
$this->registerJsFile('/js/order.js', ['depends' => JqueryAsset::class]);
