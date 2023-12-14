<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods_characteristics".
 *
 * @property int $id ID
 * @property string $parameter Параметр
 * @property string $value Значення
 * @property int $good_id Товар
 * @property int $created_at Створено
 * @property int $updated_at Відредаговано
 *
 * @property Goods $good
 */
class GoodsCharacteristics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_characteristics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parameter', 'value', 'good_id'], 'required'],
            [['value'], 'string'],
            [['good_id', 'created_at', 'updated_at'], 'integer'],
            [['parameter'], 'string', 'max' => 50],
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
            'parameter' => 'Параметр',
            'value' => 'Значення',
            'good_id' => 'Товар',
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
