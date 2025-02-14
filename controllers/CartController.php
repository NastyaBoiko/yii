<?php

namespace app\controllers;

use app\models\Cart;
use app\models\CartItem;
use app\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
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
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = null;
        if ($cart = Cart::findOne(['user_id' => Yii::$app->user->id])) {
            $dataProvider = new ActiveDataProvider([
                'query' => CartItem::find(['cart_id' => $cart->id])
                        ->with('product'),
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
        }


        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cart model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionAdd($product_id)
    {
        if ($this->request->isPost && $this->request->isAjax) {

            $cart = Cart::findOne(['user_id' => Yii::$app->user->id]);

            if (!$cart) {
                $cart = new Cart();
                $cart->user_id = Yii::$app->user->id;
                $cart->save();
            }

        
            if ($product = Product::findOne($product_id)) {
                if ($product->count) {
                    $cart_item = CartItem::findOne([
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                    ]);

                    if (!$cart_item) {
                        $cart_item = new CartItem();
                        $cart_item->cart_id = $cart->id;
                        $cart_item->product_id = $product->id;
                        $cart_item->save();
                    }


                    if ($cart_item->product_amount < $product->count) {
                        $cart_item->product_amount++;
                        $cart_item->total_amount = $cart_item->product_amount * $product->price;

                        $cart_item->save();

                        $cart->product_amount += 1;
                        $cart->total_amount += $product->price;
                        $cart->save();

                        Yii::$app->session->setFlash('success', 'Товар успешно добавлен в корзину');

                        return $this->asJson([
                            'status' => true,
                        ]);
                    } 
                } 

                return $this->asJson([
                    'status' => false,
                    'message' => 'Извините, товар закончился',
                ]);
            }
        }
    }

    public function actionIncItem($item_id)
    {
        if ($this->request->isPost && $this->request->isAjax) {

            if ($cart_item = CartItem::findOne($item_id)) {
                $product = Product::findOne($cart_item->product_id);

                if ($cart_item->product_amount < $product->count) {
                    $cart_item->product_amount++;
                    $cart_item->total_amount = $cart_item->product_amount * $product->price;
                    $cart_item->save();

                    $cart = Cart::findOne($cart_item->cart_id);
                    $cart->product_amount += 1;
                    $cart->total_amount += $product->price;
                    $cart->save();

                    return $this->asJson([
                        'status' => true,
                    ]);
                } 

                return $this->asJson([
                    'status' => false,
                    'message' => 'Извините, товар закончился',
                ]);
            }
        }
    }

    public function actionDecItem($item_id)
    {
        if ($this->request->isPost && $this->request->isAjax) {
            if ($cart_item = CartItem::findOne($item_id)) {
                $cart_item->product_amount--;
                $cart_item->total_amount -= $cart_item->product->price;
                $cart_item->save();

                $cart = Cart::findOne($cart_item->cart_id);
                $cart->product_amount -= 1;
                $cart->total_amount -= $cart_item->product->price;
                $cart->save();

                if ($cart_item->product_amount === 0) {
                    return $this->actionRemoveItem($item_id);
                }

                return $this->asJson([
                    'status' => true,
                ]);
            }
        }
    }

    public function actionRemoveItem($item_id)
    {
        if ($this->request->isPost && $this->request->isAjax) {
            if ($cart_item = CartItem::findOne($item_id)) {

                $cart = Cart::findOne($cart_item->cart_id);
                $cart->product_amount -= $cart_item->product_amount;
                $cart->total_amount -= $cart_item->total_amount;
                $cart->save();

                $cart_item->delete();

                return $this->asJson([
                    'status' => true,
                ]);
            }
        }
    }

    public function actionClear()
    {
        
        if ($this->request->isPost && $this->request->isAjax) {
            if ($cart = Cart::findOne(['user_id' => Yii::$app->user->id])) {
                $cart->delete();

                return $this->asJson([
                    'status' => true,
                ]);
            }
        }
    }

    public function actionItemCount()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            return Cart::getItemCount();
        }
    }

    /**
     * Updates an existing Cart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cart model.
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
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
