<?php

namespace app\modules\adminlte\controllers;

use yii\web\Controller;

/**
 * Default controller for the `admin-lte` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionWidget()
    {
        return $this->render('widget');
    }
}
