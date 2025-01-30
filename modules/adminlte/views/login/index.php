<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Авторизация</p>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
            ],
        ]); ?>

            <div class="input-group mb-3 field-loginform-login required"> 
                <div class="">
                    <input type="text" id="loginform-login" class="form-control" name="LoginForm[login]" autofocus="" aria-required="true" aria-invalid="true" placeholder="Login">
                    <div class="invalid-feedback"></div>
                    <!-- <input type="email" class="form-control" placeholder="Login"> -->
                </div>
                    <div class="input-group-text"> <span class="bi bi-envelope"></span> </div>
            </div>
            <div class="input-group mb-3"> 
                <input type="password" id="loginform-password" class="form-control" name="LoginForm[password]" value="" aria-required="true" placeholder="Password">
                <!-- <input type="password" class="form-control" placeholder="Login"> -->
                <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
            </div> <!--begin::Row-->

        <?# $form->field($model, 'login')->hiddenInput()->label(false) ?>

        <?# $form->field($model, 'password')->hiddenInput()->label(false) ?>
            
        <div class="form-group">
            <div class="d-flex justify-content-between">
                <?= Html::a('Отмена', ['/'], ['class' => 'btn btn-outline-primary']) ?>
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div> <!-- /.login-card-body -->
</div>

</div>

