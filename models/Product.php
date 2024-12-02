<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property string $photo
 * @property float $price
 * @property int $count
 * @property int $like
 * @property int $dislike
 * @property float|null $weight
 * @property float|null $kilocalories
 * @property string|null $shelf_life
 * @property string $description
 * @property int $category_id
 *
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price', 'description', 'category_id'], 'required'],
            [['price', 'weight', 'kilocalories'], 'number'],
            [['count', 'like', 'dislike', 'category_id'], 'integer'],
            [['description'], 'string'],
            [['title', 'photo', 'shelf_life'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование',
            'photo' => 'Изображение',
            'price' => 'Цена',
            'count' => 'Количество',
            'weight' => 'Вес',
            'kilocalories' => 'Кл. калории',
            'shelf_life' => 'Срок годности',
            'description' => 'Описание',
            'category_id' => 'Категория',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Favourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourite::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ReactionUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReactionUsers()
    {
        return $this->hasMany(ReactionUser::class, ['product_id' => 'id']);
    }

    public function upload(): bool
    {
        $result = false;
        if ($this->validate()) {
            $fileName = Yii::$app->user->id 
                . '_'
                . time()
                . '_'
                . Yii::$app->security->generateRandomString(10)
                . '.'
                . $this->imageFile->extension;
            $this->imageFile->saveAs('img/' . $fileName);
            $this->photo = $fileName;
            $result = true;
        }

        return $result;
    }

}
