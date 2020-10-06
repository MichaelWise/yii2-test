<?php

namespace app\models;

use yii\base\Exception;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::classname(), 'message' => 'Этот имя пользователя уже занято другим пользователем.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'match',
                'pattern' => '/^\D/',
                'message' => 'Телефона, должно быть в формате 8(XXX)XXX-XX-XX'
            ],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::classname(), 'message' => 'Этот email уже занят другим пользователем.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * @return User|null
     * @throws Exception
     */
    public function signup(): ?User
    {
        if ($this->validate()) {
            $user = (new User())
                ->setUsername($this->username)
                ->setEmail($this->email)
                ->setPassword($this->password)
                ->generateAuthKey();

            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}