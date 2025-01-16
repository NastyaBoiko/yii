<?php

namespace app\modules\account\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Favourite;
use Yii;

/**
 * FavouriteSearch represents the model behind the search form of `app\models\Favourite`.
 */
class FavouriteSearch extends Favourite
{
    public string $product_category = '';
    public string $product_title = '';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'product_id'], 'integer'],
            [['product_category', 'product_title'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            ...parent::attributeLabels(),
            'product_category' => 'Категория',
            'product_title' => 'Наименование товара',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Favourite::find()
                ->joinWith([
                    'product' => fn($q) => $q->joinWith('category')
                ])
                ->where([
                    'user_id' => Yii::$app->user->id,
                    'status' => 1,
                ])
                ;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'product_category' => [
                        'asc' => ['category.title' => SORT_ASC],
                        'desc' => ['category.title' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label' => 'Категория',
                    ],
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'category.id' => $this->product_category,
        ])
            ->andFilterWhere([
                'like',
                'product.title',
                $this->product_title,
            ])
        
        ;



        return $dataProvider;
    }
}
