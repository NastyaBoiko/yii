<?php

namespace app\modules\adminlte;

use Yii;
use yii\filters\AccessControl;

/**
 * admin-lte module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\adminlte\controllers';
    public $layout = 'admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'controllers' => ['admin-lte/login'],
                        'actions' => ['index'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => fn() => Yii::$app->user->identity->isAdmin,
                    ],
                ],
                'denyCallback' => fn() => Yii::$app->response->redirect('/admin-lte/login'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
