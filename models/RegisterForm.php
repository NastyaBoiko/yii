<?php
namespace app\models;

use Symfony\Component\VarDumper\VarDumper;
use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public string $name = '';
    public string $surname = '';
    public string $patronymic = '';
    public string $login = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_repeat = '';
    public bool $rules = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'phone', 'password', 'password_repeat'], 'required'], 
            [['name', 'surname', 'patronymic', 'login', 'email', 'phone', 'password', 'password_repeat'], 'string', 'max' => 255], 
            [['name', 'surname', 'patronymic'], 'match', 'pattern' => '/^[а-яё\s\-]+$/ui', 'message' => 'Только кириллица, пробел, тире'],
            [['login'], 'match', 'pattern' => '/^[a-z0-9\-]+$/ui', 'message' => 'Только латиница, цифры, тире'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6],
            [['password', 'password_repeat'], 'match', 'pattern' => '/^[a-z0-9]+$/i', 'message' => 'латиница, цифры'],
            // [['password', 'password_repeat'], 'match', 'pattern' => '/^[a-z0-9]{6,}$/i', 'message' => 'не менее 6 символов, латиница, цифры'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['rules', 'required', 'requiredValue' => 1, 'message' => 'Необходимо согласиться с правилами регистрации'],

            // +7 \( [0-9]{3} \) \- [0-9]{3} \- [0-9]{2} \- [0-9]{2}
            // +7 \( [\d]{3} \) \- [\d]{3} \- [\d]{2} \- [\d]{2}
            // +7 \( [\d]{3} \) \- [\d]{3} (\- [\d]{2}) {2}
            ['phone', 'match', 'pattern' => '/^\+7\([0-9]{3}\)\-[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/'],
            [['login'], 'unique', 'targetClass' => User::class],

            // Пароль - обязательное присутствие хотя бы 1 цифры и буквы
            // Пароль - обязательное присутствие хотя бы 1 буквы в верхнем и нижнем регистре
            // [['password', 'password_repeat'], 'match', 'pattern' => '/^(?=.*[\d])(?=.*[A-ZА-ЯЁ])(?=.*[a-zа-яё]).+$/ui'],
            // Только латиница
            // [['password', 'password_repeat'], 'match', 'pattern' => '/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])[a-zA-Z\d]+$/ui'],

        ];
    }

    public function attributeLabels() 
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'login' => 'Логин',
            'email' => 'Email',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'rules' => 'Согласие с правилами регистрации',
        ];
    }

    public function register(): object|bool
    {
        if ($this->validate()) {
            $user = new User();
            // Можно, но слишком долго
            // $user->name = $this->name;
            // $user->surname = $this->surname;
            // $user->login = $this->login;
            $user->load($this->attributes, '');
            // аналог предыдущей записи
            // $user->attributes = $this->attributes;

            $user->role_id = Role::getRoleId('user');
            $user->password = Yii::$app->security->generatePasswordHash($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();

            if (! $user->save()) {
                VarDumper::dump($user->errors); die;
            }

            // VarDumper::dump($user->attributes); die;

        } else {
            // VarDumper::dump($this->errors); die;
        }
        return $user ?? false;
    }
}