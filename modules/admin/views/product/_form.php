<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList($categories, ['prompt' => 'Выберите категорию']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <div class="d-flex justify-content-start gap-3">
        <?= Html::img('/img/' . ($model->photo ?? $model::NO_PHOTO), ['alt' => 'photo', 'class' => 'w-25'])?>
        <div class="d-flex flex-column gap-3">
            <?= $form->field($model, 'imageFile')->fileInput() ?>
            <?= $form->field($model, 'deleteImage')->checkbox() ?>
        </div>
    </div>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'kilocalories')->textInput() ?>

    <?= $form->field($model, 'shelf_life')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->id ? 'Edit' : 'Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
