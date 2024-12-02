<?php

use app\models\Favourite;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\account\models\FavouriteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Избранное';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favourite-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'layout' => "{pager}\n{summary}\n<div class='d-flex flex-wrap gap-3 justify-content-center mt-3 mb-3'>{items}</div>\n{pager}",
        'pager' => [
            'class' => LinkPager::class
        ],
        // version 1.0
        // 'itemView' => function ($model, $key, $index, $widget) {
        //     return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
        // },
        // version 2.0
        'itemView' => 'item'
    ]) ?>

    <?php Pjax::end(); ?>

</div>
