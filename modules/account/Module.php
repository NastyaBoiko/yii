<?php

namespace app\modules\account;

use Yii;
use yii\filters\AccessControl;

/**
 * account module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => fn() => Yii::$app->response->redirect('/'),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => fn() => !Yii::$app->user->identity->isAdmin,
                    ],
                ],
            ],
        ];
    }

    
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\account\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
