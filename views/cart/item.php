<?php

use yii\bootstrap5\Html;
?>
<div class="card">
  <div class="card-body">
    <div class="d-flex gap-3">
      <?= Html::img('/img/' . $model->product->photo, ['class' => 'img_cart_product']) ?>
      <div class="d-flex flex-column">
        <?= Html::a($model->product->title, ['catalog2/view', 'id' => $model->product->id], ['data-pjax' => 0])  ?>
        <div class="">
          Цена: <?= $model->product->price ?>
        </div>
      </div>
    </div>


    <div class="d-flex justify-content-between mt-3">
      <div class="">
        <?= Html::a('Удалить', ['cart/remove-item', 'item_id' => $model->id], ['class' => 'btn btn-outline-danger btn-cart-item-remove'])  ?>
      </div>

      <div class="d-flex justify-content-end gap-3">
        <?= Html::a('-', ['cart/dec-item', 'item_id' => $model->id], ['class' => 'btn btn-outline-danger btn-cart-item-dec'])  ?>
        <?= $model->product_amount ?>
        <?= Html::a('+', ['cart/inc-item', 'item_id' => $model->id], ['class' => 'btn btn-outline-success btn-cart-item-inc'])  ?>

        <div class="">
            Итого: <?= $model->total_amount ?> ₽
        </div>
      </div>
    </div>
  </div>
</div