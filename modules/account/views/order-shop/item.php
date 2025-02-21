<?php

use yii\bootstrap5\Html;
?>
<div class="card my-3">
  <div class="card-body">
    <div class="d-flex gap-3">
      <?= Html::img('/img/' . $model->product->photo, ['class' => 'img_cart_product']) ?>
      <div class="d-flex flex-column">
        <?= Html::a($model->product->title, ['catalog2/view', 'id' => $model->product->id], ['data-pjax' => 0])  ?>
        <div class="">
          Цена: <?= $model->product->price ?>
        </div>
        <div class="<?= $model->product_amount > $model->product->count ? 'text-white bg-danger py-1 px-2' : '' ?>">
          Количество товара: <?= $model->product_amount ?>
        </div>
        <div class="">
          Сумма товара: <?= $model->total_amount ?>
        </div>
      </div>
    </div>

  </div>
</div>