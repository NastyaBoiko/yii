<?php

namespace app\modules\admin\controllers;

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
                return $this->redirect('/admin-panel');
            } else {
                Yii::$app->user->logout();
                return $this->redirect('/admin-panel/login');
            }

        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionIndex2()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->isAdmin) {
                Yii::$app->session->setFlash('info', 'Вы успешно вошли в панель управления');
                return $this->redirect('/admin-panel');
            } else {
                Yii::$app->user->logout();
                return $this->redirect('/admin-panel/login');
            }

        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
