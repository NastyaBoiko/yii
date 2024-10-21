<?php
namespace app\models;

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
}