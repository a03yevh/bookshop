<?php

namespace app\models;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * SignUpForm is the model behind the sign-up form.
 *
 * @property-read User|null $user
 *
 */
class SignUpForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $password;
    public $repeat;
    public $term = false;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'repeat', 'phone'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'email'],
            ['email', 'validateEmail'],
            [['password'], 'string', 'min' => 5],
            ['repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Паролі відрізняються.'],
            [['term'], 'required', 'requiredValue' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role' => 'Роль',
            'first_name' => 'Імʼя',
            'last_name' => 'Прізвище',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'repeat' => 'Повторіть пароль',
            'term' => 'Користувацьку угоду прочитано',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function validateEmail($attribute, $params)
    {
        $query = User::find()->where(['email' => $this->email])->andWhere(
            [
                'or',
                ['status' => 10],
                ['status' => 99]
            ]
        );

        if ($query->count() !== 0) {
            $this->addError($attribute, 'E-mail вже занято.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function contact($subject, $body)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name . ' mailer'])
                ->setSubject($subject)
                ->setHtmlBody($body)
                ->send();

            return true;
        }
        return false;
    }
}
