<?php

namespace app\modules\dmf\controllers;

use app\models\Item;
use app\models\ItemProp;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
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
     * Lists all Item models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Item::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ItemProp::find()->where(['item_id' => $id]),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Item();
        $props = [new ItemProp()];

        if ($this->request->isPost) {
            if ($id = $this->request->post('Item')['id']) {
                $model = Item::findOne($id);
            }

            if ($model->load($this->request->post()) && $model->save()) {
                $props = [];

                foreach ($this->request->post('ItemProp') as $item) {
                    $prop = $item['id']
                        ? ItemProp::findOne($item['id'])
                        : new ItemProp();
                    $prop->load($item, '');
                    $prop->item_id = $model->id;
                    $props[] = $prop;
                }
                
                if (Model::validateMultiple($props)) {
                    ItemProp::deleteAll([
                        'not in',
                        'id',
                        array_map(fn($val) => $val->id, $props)
                    ]);
                    // Сначала удалить из бд (статус)
                    foreach ($props as $prop) {
                        $prop->save(false);
                    }
                } else {
                    dd(array_map(fn($val) => $val->errors, $props));
                }
            }

            // dd(array_map(fn($val) => $val->attributes, $props));

            // dd($model->load($this->request->post()));

            // return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'props' => $props,
        ]);
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $props = ItemProp::find()->where(['item_id' => $id])->all();

        if ($this->request->isPost) {

            if ($model->load($this->request->post()) && $model->save()) {
                $props = [];

                foreach ($this->request->post('ItemProp') as $item) {
                    $prop = $item['id']
                        ? ItemProp::findOne($item['id'])
                        : new ItemProp();
                    $prop->load($item, '');
                    $prop->item_id = $model->id;
                    $props[] = $prop;
                }
                
                if (Model::validateMultiple($props)) {
                    ItemProp::deleteAll([
                        'not in',
                        'id',
                        array_map(fn($val) => $val->id, $props)
                    ]);
                    // Сначала удалить из бд (статус)
                    foreach ($props as $prop) {
                        $prop->save(false);
                    }
                } 
            }


        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'props' => $props,
        ]);
    }

    /**
     * Deletes an existing Item model.
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
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
