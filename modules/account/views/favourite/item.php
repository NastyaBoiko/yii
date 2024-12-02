<?php

use yii\bootstrap5\Html;
?>
<div class="card" style="width: 18rem;">
    <!-- <img src="..." class="card-img-top" alt="..."> -->
    <?= Html::a(
        Html::img('/img/' . $model->product->photo, ['alt' => 'photo', 'class' => 'card-img-top']), 
        ['view', 'id' => $model->id]) ?>
    <div class="card-body">
        <h5 class="card-title">
        <?= Html::a(
                Html::encode($model->product->title), 
                ['view', 'id' => $model->id],
                ['class' => 'text-decoration-none']) ?>
        </h5>
        <p class="card-text"><?= Html::encode($model->product->category->title) ?></p>
        <div>
            <div class="d-flex justify-content-between">
                <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
                <?= (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin)
                    ? Html::a(
                        empty($model->status)
                            ? '🤍'
                            : '❤'
                        , ['index', 'id' => $model->product->id, 'action' => 'favourite'], ['class' => 'text-decoration-none']) 
                    : '' 
                ?>
            </div>
        </div>
        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
    </div>
</div>