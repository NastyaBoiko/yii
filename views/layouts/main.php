<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
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
    NavBar::end();
    ?>
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
    Modal::begin([
        'id' => 'cancel-modal2',
        'title' => 'Отмена заказа',
        'size' => 'modal-lg',
    ]);

    Pjax::begin([
        'id' => 'form-cancel-pjax2',
        'enablePushState' => false,
        'timeout' => 5000,
        'options' => [
            'data-first-load' => 1,
        ]
    ]); 

    Pjax::end();

    // echo $this->render('_form-modal', [
    //     'model_cancel' => $model_cancel,
    // ]);

    Modal::end();

?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
