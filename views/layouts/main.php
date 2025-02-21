<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Cart;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        // 'brandLabel' => '<img class="logo" src="/img/dragon.jpg" style="width: 50px" > my company',
        'brandLabel' => '<div class="logo"></div>' . Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        // 'options' => ['class' => 'navbar-expand-md navbar-dark bg-primary fixed-top']
        'options' => ['class' => 'navbar-expand-md color-panel fixed-top', 'data-bs-theme' => 'dark']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            // ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Каталог', 'url' => ['/catalog2']],
            ['label' => 'Каталог light', 'url' => ['/catalog']],
            ['label' => 'About', 'url' => ['/site/about']],
            // ['label' => 'Contact', 'url' => ['/site/contact']],
            // ['label' => 'my page', 'url' => ['/my-first/hello']],
            Yii::$app->user->isGuest
                ? ['label' => 'Регистрация', 'url' => ['/site/register']]
                : '',

            !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin
                ? ['label' => 'Панель управления', 'url' => ['/admin-panel']]
                : '',

            !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin
                ? ['label' => 'Личный кабинет', 'url' => ['/account']]
                : '',

            Yii::$app->user->isGuest
                ? ['label' => 'Вход в панель управления', 'url' => ['/admin-panel/login']]
                : '',

            ['label' => 'Почта', 'url' => ['/site/mail']],
                
            Yii::$app->user->isGuest
                ? ['label' => 'Вход', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Выход (' . Yii::$app->user->identity->login . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
        ]
    ]);
    ?>

    <?php if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)): ?>
        <div class="d-flex ms-5 gap-1 text-light">
            <?= Html::a('
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16" style="color:white">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                ', ['/cart/index'], ['id' => 'btn-cart']) 
            ?>

            <?php Pjax::begin([
                'id' => 'cart-item-count',
                'enablePushState' => false,
                'timeout' => 5000,
                'options' => [
                    'data-url' => '/cart/item-count'
                ]
            ]) ?>
                <?= Cart::getItemCount() ?>
            <?php Pjax::end() ?>
        </div>
    <?php endif; ?>

    <?php NavBar::end(); ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <!-- return render view file -->
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Delivery <?= date('Y') ?></div>
        </div>
    </div>
</footer>

<?php
    Yii::debug($this->params);
    if (isset($this->params['order'])) {

        $this->registerJsFile('/js/cancel-modal2.js', ['depends' => JqueryAsset::class]);


        Modal::begin([
            'id' => 'cancel-modal2',
            'title' => 'Отмена заказа',
            'size' => 'modal-lg',
        ]);
    
        // Pjax::begin([
        //     'id' => 'form-cancel-pjax2',
        //     'enablePushState' => false,
        //     'timeout' => 5000,
        //     'options' => [
        //         'data-first-load' => 1,
        //     ]
        // ]); 
    
        echo $this->render('@app/modules/admin/views/order/_form-modal2', [
            'model_cancel' => $this->params['order']['model'],
        ]);
        // Pjax::end();
    
    
        Modal::end();
    }

?>

<?php 
    if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)) {
        Modal::begin([
            'id' => 'cart-modal',
            'size' => 'modal-xl',
        ]); ?>

        <?php $cart_data = $this->render('@app/views/cart/index', [
            'dataProvider' => null
        ]) ?> 

        <?php $d_none = $this->params['cart-data'] ? "" : "d-none" ?>

        <div class="d-flex justify-content-between mb-5 <?= $d_none ?> cart-panel-top" >
            <div>
                <?= Html::a('Закрыть', '', ['class' => 'btn btn-outline-primary btn-cart-close']) ?>
            </div>
            
            <div class='d-flex justify-content-end gap-3'>
                <?= Html::a('Очистить корзину', ['/cart/clear'], ['class' => "btn btn-outline-danger btn-cart-clear"]) ?>
    
                <?= Html::a('Оформить заказ', ['/order/create'], ['class' => "btn btn-outline-success"]) ?>
    
            </div>
        </div>

        <?= $cart_data ?>

        <div class="d-flex justify-content-between mt-5">
            <div>
                <?= Html::a('Закрыть', '', ['class' => 'btn btn-outline-primary btn-cart-close']) ?>
            </div>
            <div class='d-flex justify-content-end gap-3'>
                <?= Html::a('Очистить корзину', ['/cart/clear'], ['class' => "btn btn-outline-danger btn-cart-clear $d_none btn-cart-manger"]) ?>
    
                <?= Html::a('Оформить заказ', ['/order/create'], ['class' => "btn btn-outline-success $d_none btn-cart-manger"]) ?>
    
            </div>
        </div>


        <?php
        Modal::end();
        $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]);
    }

    if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)) {
        Modal::begin([
            'id' => 'info-modal',
        ]);

        echo '<div id="text-error"></div>';

        Modal::end();
        $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]);
    }
    
?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
