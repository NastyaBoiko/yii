<?php

use app\models\Cart;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['cart-data'] = $dataProvider && $dataProvider->totalCount;
?>
<div class="cart-index">


    <?php Pjax::begin([
                'id' => 'cart-pjax',
                'enablePushState' => false,
                'timeout' => 5000,
            ]);
    ?>

    <?php if ($dataProvider && $dataProvider->totalCount): ?>

    <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => 'item'
        ]) ?>

    <?php else: ?>
        <div class="cart-empty">Корзина пустая</div>
    <?php endif ?>

    <?php Pjax::end(); ?>

</div>
