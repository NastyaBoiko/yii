<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\Product10Search $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Топ 10 продуктов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'photo',
            'price',
            'count',
            'like',
            //'dislike',
            //'weight',
            //'kilocalories',
            //'shelf_life',
            //'description:ntext',
            //'category_id',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
