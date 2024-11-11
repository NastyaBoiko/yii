<?php

use yii\bootstrap5\Html;

?>

<div class="admin-default-index">
    <h3>Панель администратора</h3>
    <?= Html::a('Управление категориями', ['/admin/category'], ['class' => 'btn btn-primary btn-category']) ?>
    <?= Html::a('Управление товарами', ['/admin/product'], ['class' => 'btn btn-primary btn-category']) ?>
</div>
