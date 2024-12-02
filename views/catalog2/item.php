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
                Html::encode($model->title), 
                ['view', 'id' => $model->id],
                ['class' => 'text-decoration-none']) ?>
        </h5>
        <p class="card-text"><?= Html::encode($model->category->title) ?></p>
        <div>
            <div class="d-flex justify-content-between">
                <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
                <?= (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin)
                    ? Html::a(
                        empty($model->favourites[0]->status)
                            ? '🤍'
                            : '❤'
                        , ['index', 'id' => $model->id, 'action' => 'favourite'], ['class' => 'text-decoration-none btn-favorite']) 
                    : '' 
                ?>
            </div>
            <?= !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin
                ? Html::a('Заказать', ['/account/order/create', 'product_id' => $model->id], ['class' => 'btn btn-outline-success w-100 mt-2'])
                : "" ?>
            <?= !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin
                ? Html::a('Заказать вариант 2', ['/account/order/create2', 'product_id' => $model->id], ['class' => 'btn btn-outline-success w-100 mt-2'])
                : "" ?>
            <?= !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin
                ? Html::a('Заказать вариант 3', ['/account/order/create3', 'product_id' => $model->id], ['class' => 'btn btn-outline-success w-100 mt-2'])
                : "" ?>
        </div>
        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
    </div>
</div>