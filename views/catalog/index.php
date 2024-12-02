<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="product-index">


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => fn($model) => 
                    "<div>"
                        . Html::encode($model->title) 
                        . Html::img('/img/' . $model->photo, ['class' => 'w-25 d-block mt-2', 'alt' => 'photo'])
                        . "</div>",
            ],
            'price',
            'count',
            //'like',
            //'dislike',
            //'weight',
            //'kilocalories',
            //'shelf_life',
            //'description:ntext',
            [
                'attribute' => 'category_id',
                'value' => fn($model) => $categories[$model->category_id],
                'filter' => $categories,
                'headerOptions' => [
                    'width' => 150,
                ],
                'contentOptions' => [
                    'class' => 'text-center'
                ]
            ],
            //'category_id',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
