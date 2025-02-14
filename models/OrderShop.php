<?php

namespace app\models;

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
            [['total_amount', 'product_amount', 'user_id'], 'integer'],
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
}
