<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reaction_user".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int|null $status
 *
 * @property Product $product
 * @property User $user
 */
class ReactionUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reaction_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id'], 'required'],
            [['product_id', 'user_id', 'status'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
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
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    
    public static function changeReaction(int $product_id, string $reaction): int
    {
        $model = self::findOne([
            'product_id' => $product_id,
            'user_id' => Yii::$app->user->id,
        ]);


        if (!$model) {
            $model = new self;
            $model->user_id = Yii::$app->user->id;
            $model->product_id = $product_id;
        }

        $product = Product::findOne(['id' => $product_id]);

        if ($reaction == 'like') {
            if ($model->status !== null) {
                $model->status = null;
                $product->like--;

            } else {
                $model->status = 1;
                $product->like++;
            }
            $result = $product->like;

        }

        if ($reaction == 'dislike') {
            if ($model->status !== null) {
                $model->status = null;
                $product->dislike--;
            } else {
                $model->status = 0;
                $product->dislike++;
            }
            $result = $product->dislike;
        }
        
        $model->save();
        $product->save();
        return $result;
    }

}
