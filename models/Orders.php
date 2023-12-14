<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id ID
 * @property int $order_id No. замовлення
 * @property int $user_info Замовник
 * @property int $good_id Товар
 * @property int $count Кількість
 * @property float $good_price Ціна за шт.
 * @property float $price Ціна за все
 * @property string $payment Оплата
 * @property string $delivery Доставка
 * @property string $status Статус
 * @property int $created_at Створено
 * @property int $updated_at Відредаговано
 *
 * @property Goods $good
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'user_info', 'good_id', 'count', 'good_price', 'price', 'payment', 'delivery'], 'required'],
            [['good_id', 'count', 'created_at', 'updated_at'], 'integer'],
            [['good_price', 'price'], 'number'],
            [['delivery', 'status'], 'string'],
            [['payment'], 'string', 'max' => 100],
            [['order_id'], 'string', 'max' => 50],
            [['good_id'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::class, 'targetAttribute' => ['good_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'No. замовлення',
            'user_info' => 'Замовник',
            'good_id' => 'Товар',
            'count' => 'Кількість',
            'good_price' => 'Ціна за шт.',
            'price' => 'Ціна за все',
            'payment' => 'Оплата',
            'delivery' => 'Доставка',
            'status' => 'Статус',
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
     * Gets query for [[Good]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Goods::class, ['id' => 'good_id']);
    }
}
