<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">
    <?php Pjax::begin([
        'id' => 'form-cancel-pjax',
        'enablePushState' => false,
        'timeout' => 5000
    ]); ?>

        <?php $form = ActiveForm::begin([
            'id' => 'form-cancel-modal',
            'options' => [
                'data-pjax' => true,
            ]
        ]); ?>

        <?= $form->field($model_cancel, 'comment_admin')->textarea(['rows' => 4]) ?>

        <div class="form-group d-flex justify-content-between">
            <?= Html::a('Назад', [''], ['class' => 'btn btn-info btn-modal-close']) ?>
            <?= Html::submitButton('Отменить заказ', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>

</div>
