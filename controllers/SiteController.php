<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegisterForm;
use Symfony\Component\VarDumper\VarDumper as VarDumper;
use yii\bootstrap5\ActiveForm;

// use yii\helpers\VarDumper;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Yii::debug(Yii::$app->security->generatePasswordHash('123123'));
        // VarDumper::dump(Yii::$app->user?->identity?->userLogin);
        // VarDumper::dump(Yii::$app->user?->identity?->login); die;
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('info', 'Вы успешно авторизовались в системе');

            return Yii::$app->user->identity->isAdmin
                    ? $this->redirect('/admin-panel')
                    : $this->redirect('/account');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        Yii::$app->session->setFlash('info', 'Вы успешно вышли из системы');

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $model = new RegisterForm();

        

        // if ($this->request->isPost)
        // Yii::$app->request->isPost можно удалить load с пустым массивом вернет false
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($user = $model->register()) {
                if (Yii::$app->user->login($user, 60*60)) {

                    Yii::$app->session->setFlash('info', 'Вы успешно зарегистрировались в системе');
                    return Yii::$app->user->identity->isAdmin
                                ? $this->redirect('/admin-panel')
                                : $this->redirect('/account');
                }
                

                // VarDumper::dump($user, 10, true); die;
            }
            // VarDumper::dump(Yii::$app->request->post(), 10, true); 
            // $model->name = Yii::$app->request->post('RegisterForm')['name'];
            // VarDumper::dump($model->attributes, 10, true); die;
        }
        return $this->render('register', compact('model'));

    }

    public function actionMail()
    {
        Yii::$app->mailer->htmlLayout = '@app/mail/layouts/html';

        if (
            Yii::$app->mailer
                    ->compose('mail', [])
                    ->setFrom('a.boiko17@mail.ru')
                    ->setTo('a.boiko17@mail.ru')
                    ->setSubject('Тест')
                    ->send()
        ) {
            Yii::$app->session->setFlash('success', 'Почта отправлена');
        } else {
            Yii::$app->session->setFlash('danger', 'Почта НЕ отправлена');
        }

        return $this->render('index');
    }
}
