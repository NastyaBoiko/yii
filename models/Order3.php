<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $created_at
 * @property string $date_order
 * @property string $time_order
 * @property string $address
 * @property string|null $comment
 * @property int $user_id
 * @property int $status_id
 * @property int $product_id
 * @property int $pay_type_id
 * @property int|null $outpost_id
 * @property string|null $comment_admin
 *
 * @property Outpost $outpost
 * @property PayType $payType
 * @property Product $product
 * @property Status $status
 * @property User $user
 */
class Order3 extends \yii\db\ActiveRecord
{
    const SCENARIO_OUTPOST = 'outpost';
    const SCENARIO_COMMENT = 'comment';

    public bool $check = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_order', 'time_order', 'address', 'user_id', 'status_id', 'product_id', 'pay_type_id'], 'required'],
            [['user_id', 'status_id', 'product_id', 'pay_type_id', 'outpost_id'], 'integer'],
            [['address', 'comment', 'comment_admin'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::class, 'targetAttribute' => ['pay_type_id' => 'id']],
            [['outpost_id'], 'exist', 'skipOnError' => true, 'targetClass' => Outpost::class, 'targetAttribute' => ['outpost_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],

            ['check', 'boolean'],
            ['outpost_id', 'required', 'on' => self::SCENARIO_OUTPOST],
            ['comment', 'required', 'on' => self::SCENARIO_COMMENT],

            [['date_order'], 'validateDateOrder'],
            [['time_order'], 'validateDateTimeOrder'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Время создания заказа',
            'date_order' => 'Дата получения',
            'time_order' => 'Время получения',
            'address' => 'Адрес',
            'comment' => 'Комментарий к заказу',
            'user_id' => 'User ID',
            'status_id' => 'Стастус заказа',
            'product_id' => 'Product ID',
            'pay_type_id' => 'Тип оплаты',
            'outpost_id' => 'Пункт выдачи',
            'comment_admin' => 'Причина отказа',
        ];
    }

    public function validateDateOrder($attribute, $params)
    {
        $date1 = new \DateTime("now");
        $date2 = new \DateTime($this->date_order);

        if ($date2 >= $date1) {
            $model = self::findOne([
                    'date_order' => $this->date_order,
                    'time_order' => $this->time_order,
                    'status_id' => Status::getStatusId('Новый'),
                ]);

            // $model = self::find()
            //     ->where([
            //         'date_order' => $this->date_order,
            //         'time_order' => $this->time_order,
            //         'status_id' => Status::getStatusId('Новый'),
            //     ])
            //     ->asArray()
            //     ->all();

            // VarDumper::dump($model->createCommand()->rawSql, 10, true); die;

            if ($model) {
                $this->addError($attribute, 'Выбранная дата и время заняты');
            }
        } else {
            $this->addError($attribute, 'Дата выбрана неправильно');
        }

    }

    public function validateDateTimeOrder($attribute, $params)
    {
        
        if (empty($this->date_order)) {
            $this->addError($attribute, 'Необходимо установить дату заявки');
        }

        if ($this->time_order < '09:00') {
            $this->addError($attribute, 'Время должно быть больше 9:00');
        }
        // VarDumper::dump($this->attributes, 10, true);
        // VarDumper::dump($this->errors, 10, true);
        // die;
    }

    /**
     * Gets query for [[Outpost]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOutpost()
    {
        return $this->hasOne(Outpost::class, ['id' => 'outpost_id']);
    }

    /**
     * Gets query for [[PayType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayType()
    {
        return $this->hasOne(PayType::class, ['id' => 'pay_type_id']);
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
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
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
