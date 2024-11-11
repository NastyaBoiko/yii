<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'photo',
                'format' => 'html',
                'value' => Html::img('/img/' . $model->photo, ['class' => 'w-50', 'alt' => 'photo'])
            ],
            'price',
            'count',
            'weight',
            'kilocalories',
            'shelf_life',
            'description:ntext',
            [
                'attribute' => 'category_id',
                'value' => $categories[$model->category_id],
            ],
        ],
    ]) ?>

</div>
