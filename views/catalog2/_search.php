<?php

use app\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product2Search $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'id' => 'form-product-search',
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


    <div class="d-flex gap-5 align-items-end">
        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'title_search')->hiddenInput()->label(false) ?>
    
        <?= $form->field($model, 'category_id')->dropDownList(Category::getCategories(), [
            'prompt' => 'Выберите категорию',
        ]) ?>
    
        <div class="form-group">
            <?= Html::a('Reset', ['/'], ['class' => '']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
