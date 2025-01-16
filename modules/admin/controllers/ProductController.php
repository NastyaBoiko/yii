<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\Product;
use app\modules\admin\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $categories = Category::getCategories();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'categories' => $categories,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
        $categories = Category::getCategories();

        // $obj = new Category();

        // VarDumper::dump($obj->getProducts(), 10, true); 
        // VarDumper::dump($obj->products, 10, true);
        // VarDumper::dump($categories, 10, true); die;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                if (is_null($model->imageFile) || $model->upload()) {
                    // die;

                    if ($model->save(false)) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        VarDumper::dump($model->errors, 10, true); die;
                    }
                }
                

            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categories = Category::getCategories();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                // Без записи в бд
                // if (is_null($model->imageFile) || $model->upload()) {
                    // die;

                // С записью в бд
                if ($model->upload()) {
                    if ($model->save(false)) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        VarDumper::dump($model->errors, 10, true); die;
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
