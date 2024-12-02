<?php

namespace app\models;

use Symfony\Component\VarDumper\VarDumper;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property string $login
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string|null $photo
 * @property string $created_at
 * @property int $role_id
 *
 * @property Role $role
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'phone', 'password', 'role_id'], 'required'],
            [['created_at'], 'safe'],
            [['role_id'], 'integer'],
            [['name', 'surname', 'patronymic', 'login', 'email', 'phone', 'password', 'photo'], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'login' => 'Login',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'role_id' => 'Role ID',
        ];
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * Gets query for [[Favourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourite::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ReactionUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReactionUsers()
    {
        return $this->hasMany(ReactionUser::class, ['user_id' => 'id']);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */ 
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByUsername($login)
    {
        return self::findOne(['login' => $login]);
    }

    public function validatePassword($password)
    {
        // VarDumper::dump($password); 
        // VarDumper::dump($this->attributes); die;

        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getIsAdmin(): bool
    {
        return $this->role_id == Role::getRoleId('admin');
    }

    public function getUserLogin(): string
    {
        return $this->login;
    }

    public function getFio(): string
    {
        return $this->surname 
                . ' '
                . mb_substr($this->name, 0, 1)
                . '.'
                . ($this->patronymic 
                    ? mb_substr($this->patronymic, 0, 1) . '.'
                    : '')
                ;
    }
}
