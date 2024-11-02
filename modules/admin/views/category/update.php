<?php

use yii\helpers\Html;
// use yii\helpers\VarDumper;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = 'Редактирование категории: ' . $model->title;
// $this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';

// VarDumper::dump($this, 10, true);
?>
<div class="category-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
