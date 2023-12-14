<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * FeedbackForm is the model behind the contact form.
 */
class FeedbackForm extends Model
{
    public $name;
    public $phone;
    public $message;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'message'], 'required'],
            [['name'], 'string', 'min' => 2, 'max' => 100],
            [['phone', 'message'], 'string'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ім’я',
            'phone' => 'Телефон',
            'message' => 'Повідомлення',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function contact($subject, $body)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo(Yii::$app->params['supportEmail'])
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name . ' mailer'])
                ->setSubject($subject)
                ->setHtmlBody($body)
                ->send();

            return true;
        }
        return false;
    }
}
