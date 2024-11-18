<?php

use yii\bootstrap5\Html;
?>
<div class="card" style="width: 18rem;">
    <!-- <img src="..." class="card-img-top" alt="..."> -->
    <?= Html::a(
        Html::img('/img/' . $model->photo, ['alt' => 'photo', 'class' => 'card-img-top']), 
        ['view', 'id' => $model->id]) ?>
    <div class="card-body">
        <h5 class="card-title">
        <?= Html::a(
                $model->title, 
                ['view', 'id' => $model->id],
                ['class' => 'text-decoration-none']) ?>
        </h5>
        <p class="card-text"><?= $model->category->title ?></p>
        <div>
            <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Заказать', ['/account/order/create', 'product_id' => $model->id], ['class' => 'btn btn-outline-success w-100 mt-2']) ?>
        </div>
        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
    </div>
</div>