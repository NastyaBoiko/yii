<?php

use app\models\Order;
use app\models\Outpost;
use app\models\Status;
use app\widgets\Alert;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\admin\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Панель администратора';
$this->params['breadcrumbs'][] = $this->title;
$statusesTitle = array_flip($statuses);
?>
<div class="order-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Управление товарами', ['/admin-panel/product'], ['class' => 'btn btn-outline-primary']) ?>
        <?= Html::a('Управление категориями', ['/admin-panel/category'], ['class' => 'btn btn-outline-primary']) ?>
    </p>

    <div class="mt-5 mb-3">
        <h3>Управление заказами</h3>
    </div>
    <?php Pjax::begin([
            'id' => 'admin-order-pjax',
            'enablePushState' => false,
            'timeout' => 5000
        ]); ?>

        <?php if (Yii::$app->session->hasFlash('cancel-modal-info')) {
            Yii::$app->session->setFlash('warning', Yii::$app->session->getFlash('cancel-modal-info'));
            Yii::$app->session->removeFlash('cancel-modal-info');
            echo Alert::widget();
        }
        ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => ' ',
        ],
        'pager' => [
            // 'class' => LinkPager::class,
            'class' => 'yii\bootstrap5\LinkPager',
        ],
        'columns' => [

            'id',
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:d.m.Y H:i:s'],
            ],
            [
                'attribute' => 'user_id',
                'value' => fn($model) => $model->user->fio,
                'headerOptions' => [
                    'width' => 200,
                ],
            ],
            [
                'label' => 'Дата и время получения',
                'attribute' => 'date_order',
                'value' => fn($model) => 
                    Yii::$app->formatter->asDate($model->date_order, 'php:d.m.Y ')
                    . Yii::$app->formatter->asTime($model->time_order, 'php:H:i:s'),
            ],

            [
                'attribute' => 'status_id',
                'value' => fn($model) => $model->status->title,
                'filter' => $statuses,
                'headerOptions' => [
                    'width' => 200,
                ]
            ],
            [
                'attribute' => 'comment',
                'value' => fn($model) => $model->comment,
            ],
            [
                'attribute' => 'outpost_id',
                'value' => fn($model) => $model->outpost?->title,
                'filter' => Outpost::getOutposts(),
                'headerOptions' => [
                    'width' => 200,
                ]
            ],
            //'status_id',
            //'outpost_id',
            //'comment',


            //'user_id',
            //'product_id',
            //'pay_type_id',
            //'comment_admin',
            [
                'label' => 'Действия с заказом',
                'format' => 'raw',
                'value' => function($model) use ($statusesTitle) {
                    $view = Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-primary']);
                    $cancel = '';
                    $cancel_modal = '';
                    $apply = '';

                    if ($model->status_id == $statusesTitle['Новый']) {
                        $apply = Html::a('Подтвердить', ['apply', 'id' => $model->id], ['class' => 'btn btn-outline-success',]);
                        $cancel = Html::a('Отменить', ['cancel', 'id' => $model->id], ['class' => 'btn btn-outline-warning',]);
                        $cancel_modal = Html::a('Отменить (модалка)', ['cancel-modal', 'id' => $model->id], ['class' => 'btn btn-outline-warning btn-cancel-modal',]);
                                //     'data' => [
                                //         'confirm' => 'Точно ли хотите удалить?',
                                //         'method' => 'post',
                                //     ],
                                // ])
                    }
                    // $delete = $model->status_id == Status::getStatusId('Новый') 
                    //     ? Html::a('Удалить', ['delete', 'id' => $model->id], [
                    //         'class' => 'btn btn-outline-danger',
                    //         'data' => [
                    //             'confirm' => 'Точно ли хотите удалить?',
                    //             'method' => 'post',
                    //         ],
                    //     ])
                    //     : '';
                    return "<div class='d-flex flex-wrap gap-3'>$view $apply $cancel $cancel_modal</div>";
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php
    if ($dataProvider->count) {
        Modal::begin([
            'id' => 'cancel-modal',
            'title' => 'Отмена заказа',
            'size' => 'modal-lg',
        ]);

        echo $this->render('_form-modal', [
            'model_cancel' => $model_cancel,
        ]);

        Modal::end();

        $this->registerJsFile('/js/cancel-modal.js', ['depends' => JqueryAsset::class]);
    }
?>
