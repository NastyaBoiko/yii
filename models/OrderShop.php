<?php

namespace app\models;

use Exception;
use Yii;

/**
 * This is the model class for table "order_shop".
 *
 * @property int $id
 * @property string $created_at
 * @property int $total_amount
 * @property int $product_amount
 * @property int $user_id
 *
 * @property OrderShopItem[] $orderShopItems
 * @property User $user
 */
class OrderShop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_shop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['product_amount', 'user_id'], 'integer'],
            [['total_amount'], 'number'],
            [['user_id'], 'required'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'total_amount' => 'Total Amount',
            'product_amount' => 'Product Amount',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[OrderShopItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderShopItems()
    {
        return $this->hasMany(OrderShopItem::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function orderCreate(): int|bool
    {
        if ($cart = Cart::findOne(['user_id' => Yii::$app->user->id])) {

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $orderShop = new self();
                $orderShop->attributes = $cart->attributes;

                $orderShop->save(false);
                // dd($orderShop->errors);

                $cartItems = CartItem::find()
                            ->with('product')
                            ->where(['cart_id' => $cart->id])
                            // ->asArray()
                            ->all()
                            ;

                // Проверка что товар закончился

                foreach ($cartItems as $cartItem) {

                    if ($cartItem->product_amount <= $cartItem->product->count) {
                        $orderItem = new OrderShopItem();
                        $orderItem->attributes = $cartItem->attributes;
                        $orderItem->order_id = $orderShop->id;
                        $orderItem->product_title = $cartItem->product->title;
                        $orderItem->product_cost = $cartItem->product->price;

                        $product = Product::findOne($cartItem->product_id);
                        $product->count -= $cartItem->product_amount;
                        if (!$product->save()) {
                            dd($product->errors);
                        } 
                        // false чтобы попадать в Exception из бд
                        $orderItem->save(false);
                    } else {
                        throw new \Exception("Товара в магазине по одной из позиций не достаточно!");
                    }
                }

                $transaction->commit();
                $cart->delete();

                return $orderShop->id;
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('shop', $e->getMessage());
            } catch (\Throwable $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('shop', $e->getMessage());
                // Yii::debug($e->getMessage());
                // dd($e->getMessage());
            }
        }

        return false;
    }
}
