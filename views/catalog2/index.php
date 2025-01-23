<?php

use app\models\Product;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\Product2Search $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="">
        <?= Html::a('Топ 10', ['/product10'], ['class' => 'btn btn-outline-primary my-3']) ?>
    </div>

    <?php Pjax::begin([
        'id' => 'catalog-pjax',
        // 'enablePushState' => false,
    ]); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'layout' => "{pager}\n{summary}\n<div class='d-flex flex-wrap gap-3 justify-content-center mt-3 mb-3'>{items}</div>\n{pager}",
        'pager' => [
            'class' => LinkPager::class
        ],
        // version 1.0
        // 'itemView' => function ($model, $key, $index, $widget) {
        //     return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
        // },
        // version 2.0
        'itemView' => 'item'
    ]) ?>

    <?php Pjax::end(); ?>

</div>

<?php

$this->registerJsFile('/js/catalog.js', ['depends' => JqueryAsset::class]);

?>