<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);

?>
<div class="product-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-info']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-outline-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'photo',
                'format' => 'html',
                'value' => Html::img('/img/' . ($model->photo ?? $model::NO_PHOTO), ['class' => 'w-25', 'alt' => 'photo']),
                // 'visible' => (bool) $model->photo,
            ],
            'price',
            'count',
            'like',
            'dislike',
            'weight',
            'kilocalories',
            'shelf_life',
            [
                'attribute' => 'description',
                'format' => 'html',
            ],
            [
                'attribute' => 'category_id',
                'value' => $categories[$model->category_id],
            ],
        ],
    ]) ?>

</div>
