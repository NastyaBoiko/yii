<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_shop_item".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $product_title
 * @property int $product_amount
 * @property int $product_cost Стоимость на момент покупки
 *
 * @property OrderShop $order
 * @property Product $product
 */
class OrderShopItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_shop_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'product_title', 'product_amount', 'product_cost'], 'required'],
            [['order_id', 'product_id', 'product_amount', 'product_cost'], 'integer'],
            [['product_title'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderShop::class, 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'product_title' => 'Product Title',
            'product_amount' => 'Product Amount',
            'product_cost' => 'Product Cost',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(OrderShop::class, ['id' => 'order_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
