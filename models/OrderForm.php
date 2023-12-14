<?php

namespace app\models;

use Yii;
use yii\base\Model;

class OrderForm extends Model
{
    public $email;
    public $phone;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $payment;
    public $delivery;
    public $delivery_info;
    public $status;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'first_name', 'last_name', 'payment', 'delivery'], 'required'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 255],
            [['payment', 'delivery', 'status'], 'string', 'max' => 100],
            [['delivery_info'], 'string', 'max' => 255],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'first_name' => 'Імʼя',
            'middle_name' => 'По батькові',
            'last_name' => 'Прізвище',
            'payment' => 'Оплата',
            'delivery' => 'Доставка',
            'delivery_info' => 'Інформація',
            'status' => 'Статус замовлення',
        ];
    }
}
