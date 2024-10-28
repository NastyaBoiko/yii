<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>
<h3>Регистрация</h3>
<div class="row">
    <div class="col-lg-5">

        <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'surname') ?>

            <?= $form->field($model, 'patronymic') ?>

            <?= $form->field($model, 'login') ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'phone') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'password_repeat')->passwordInput() ?>

            <?= $form->field($model, 'rules')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>