<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property int $id ID
 * @property string $type Тип
 * @property string $value Значення
 * @property int $created_at Створено
 * @property int $updated_at Відредаговано
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'value'], 'required'],
            [['type'], 'string'],
            [['value'], 'unique'],
            [['created_at', 'updated_at'], 'integer'],
            [['value'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'value' => 'Значення',
            'created_at' => 'Створено',
            'updated_at' => 'Відредаговано',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function checkValue()
    {
        if (($this->type == 'Адреса') || ($this->type == 'Час роботи')) {
            return true;
        }

        if ($this->type == 'Електронна адреса') {
            return filter_var($this->value, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $this->value);
        }

        if ($this->type == 'Телефон') {
            $phone = $this->value;
            if (preg_match('/^[+][0-9]/', $phone)) {
                $count = 1;
                $phone = str_replace(['+'], '', $phone, $count);
            }
            $phone = str_replace([' ', '.', '-', '(', ')'], '', $phone);

            return preg_match('/^[0-9]{10,12}\z/', $phone);
        }

        if ($this->type == 'Instagram') {
            return preg_match('/(instagram.com|instagr.am|instagr.com)\/(\w+)/', $this->value);
        }

        if ($this->type == 'Telegram') {
            return preg_match('/(t(elegram)?\.me|telegram\.org)\/([a-z0-9\_]{5,32})/', $this->value);
        }

        if ($this->type == 'Viber') {
            if (preg_match('/^[+][0-9]/', $this->value)) {
                $count = 1;
                $this->value = str_replace(['+'], '', $this->value, $count);
            }
            $this->value = str_replace([' ', '.', '-', '(', ')'], '', $this->value);

            return preg_match('/^[0-9]{10,12}\z/', $this->value);
        }
    }
}
