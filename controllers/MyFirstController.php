<?php

namespace app\controllers;

use app\models\MyModel;
use yii\web\Controller;

class MyFirstController extends Controller
{

    public function actionHello() 
    {
        $data = MyModel::getImage();
        return $this->render('index', compact('data'));
    }

    public function actionHelloUser() {
        $user = 'Vasya';
        // return $this->render('hello', [
        //     'user' => $user
        // ]);
        return $this->render('hello', compact('user'));
    }
}