<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;
use yii\widgets\ListView;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

// $this->params['cart-data'] = $dataProvider && $dataProvider->totalCount;
?>
<div class="order-shop-index">
    <h3 class="mb-3">Оформление заказа</h3>

    <div class="d-flex justify-content-end mb-3">
        <?= Html::a('Оформить заказ', ['create'], ['data-method' => 'post','class' => 'btn btn-outline-success']) ?>
    </div>

    <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => 'item',
            'pager' => [
                'class' => LinkPager::class,
            ],
            'layout' => "{items}\n{pager}",
        ]) ?>
    
    <div class="d-flex gap-3 flex-column align-items-end border-bottom border-top">
        <div class="">
            Количество товаров в корзине: <span class="fw-bold fs-3"><?= $cart->product_amount ?></span>
        </div>
        <div class="">
            Общая сумма: <span class="fw-bold fs-3"><?= $cart->total_amount ?></span>
        </div>
    </div>
    <div class="">
        Добавить информацию по карте
    </div>

    <div class="d-flex justify-content-end mt-3">
        <?= Html::a('Оформить заказ', ['create'], ['data-method' => 'post','class' => 'btn btn-outline-success']) ?>
    </div>

</div>
