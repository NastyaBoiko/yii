<?php

namespace app\modules\adminlte\controllers;

use app\models\LoginForm;
use Yii;

class LoginController extends \yii\web\Controller
{
    // public $layout = 'login';
    
    public function actionIndex()
    {
        $this->layout = 'login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->isAdmin) {
                Yii::$app->session->setFlash('info', 'Вы успешно вошли в панель управления');
                return $this->redirect('/admin-lte');
            } else {
                Yii::$app->user->logout();
                return $this->redirect('/admin-lte/login');
            }

        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
