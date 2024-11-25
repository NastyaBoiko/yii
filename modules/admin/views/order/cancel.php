<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = 'Отмена заказа: № ' 
                . $model->id 
                . " от " 
                . Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s');

?>
<div class="order-cancel">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
