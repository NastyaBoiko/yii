<?php

use app\models\Status;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = "Заказ №" . $model->id 
                . " от " 
                . Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s');

\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h3><?= Html::encode($this->title) ?></h3>
    <p id='block-btn' >
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-primary']) ?>
        
        <?= $model->status->id == Status::getStatusId('Новый')
                ? Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger btn-confirm',
                    // 'data' => [
                    //     'confirm' => 'Вы точно хотите удалить данный заказ?',
                    //     'method' => 'post',
                    // ],
                ]) 
                : ""
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:d.m.Y H:i:s'],
            ],
            [
                'attribute' => 'date_order',
                'format' => ['datetime', 'php:d.m.Y'],
            ],
            'time_order',
            'address',

            [
                'attribute' => 'status_id',
                'value' => $model->status->title,
            ],
            [
                'attribute' => 'pay_type_id',
                'value' => $model->payType->title,
            ],
            [
                'attribute' => 'comment',
                'value' => $model->comment,
                'visible' => (bool)$model->comment,
            ],
            [
                'attribute' => 'outpost_id',
                'value' => $model->outpost?->title,
                'visible' => (bool)$model->outpost_id,
            ],
            [
                'attribute' => 'comment_admin',
                'value' => $model->comment_admin,
                'visible' => (bool)$model->comment_admin,
            ],

            'product_id',
        ],
    ]) ?>

</div>

<?= $this->render('modal')?>
