<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "outpost".
 *
 * @property int $id
 * @property string $title
 *
 * @property Order[] $orders
 */
class Outpost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outpost';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['outpost_id' => 'id']);
    }

    public static function getOutposts()
    {
        return self::find()
            ->select('title')
            ->indexBy('id')
            ->column()
            ;
        // return (new Query)
        //     ->select('title')
        //     ->from('category')
        //     ->indexBy('id')
        //     ->column()
        //     ;
    }
}
