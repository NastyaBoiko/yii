<?php

namespace app\controllers;

use app\models\Category;
use app\models\Favourite;
use app\models\Product;
use app\models\Product2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * Catalog2Controller implements the CRUD actions for Product model.
 */
class Catalog2Controller extends Controller
{
    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex($action = null, $id = null)
    {
        $searchModel = new Product2Search();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $categories = Category::getCategories();

        // VarDumper::dump($this->request->queryParams, 10, true); die;

        if (isset($action)) {
            switch ($action) {
                case 'favourite':
                    Favourite::changeForUser($id);
                    break;
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
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
