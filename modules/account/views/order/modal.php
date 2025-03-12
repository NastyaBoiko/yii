<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\web\JqueryAsset;

 ?>

<?php
Modal::begin([
    'id' => 'confirm-modal',
    'title' => 'Подтверждение удаления',
]); ?>

<div class="">Удалить заказ? </div>
<div class="d-flex justify-content-between mt-5">
    <div class='d-flex justify-content-end gap-3'>
        
        <?= Html::a('Удалить', '', ['class' => "btn btn-outline-danger btn-delete", 'data-method' => 'post']) ?>

        <?= Html::a('Отменить', '', ['class' => "btn btn-outline-primary btn-cancel"]) ?>

    </div>
</div>

<?php
Modal::end();

$this->registerJsFile('/js/modal.js', ['depends' => JqueryAsset::class]);

?>