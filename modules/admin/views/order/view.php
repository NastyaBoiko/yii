<?php

use app\models\Order;
use app\models\Status;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = "Заказ №" . $model->id 
                . " от " 
                . Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s');

\yii\web\YiiAsset::register($this);

$model->scenario = Order::SCENARIO_CANCEL;

$this->params['order'] = [
    'model' => $model,
]
?>
<div class="order-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p id='order-view_block-btn'>
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-info']) ?>
        <?php
            if ($model->status_id == Status::getStatusId('Новый')) {
                echo Html::a('Отменить (модалка 2)', ['cancel-modal2', 'id' => $model->id], ['class' => 'btn btn-outline-warning btn-cancel-modal',]);
            }
        ?>
        <?= $model->status_id == Status::getStatusId('Новый') 
            ? Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger',
                'data' => [
                    'confirm' => 'Точно ли хотите удалить?',
                    'method' => 'post',
                ],
            ])
            : ''
        ?>
    </p>
    <?php Pjax::begin([
        'id' => 'order-view-pjax'
    ]) ?>
    <?php if (Yii::$app->session->hasFlash('cancel-modal-info')) {
            Yii::$app->session->setFlash('warning', Yii::$app->session->getFlash('cancel-modal-info'));
            Yii::$app->session->removeFlash('cancel-modal-info');
            echo Alert::widget();
        }
    ?>

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
            [
                'attribute' => 'user_id',
                'value' => $model->user->fio,
            ],
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
        ],
    ]) ?>

    <?php Pjax::end() ?>

</div>
