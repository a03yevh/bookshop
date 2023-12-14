<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subcategory".
 *
 * @property int $id ID
 * @property string $title Назва
 * @property string $url_key Ключ
 * @property int $category_id Категорія
 * @property int $created_at Створено
 * @property int $updated_at Відредаговано
 *
 * @property Category $category
 * @property Items[] $items
 */
class Subcategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subcategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'url_key', 'category_id'], 'required'],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['url_key'], 'string', 'max' => 25],
            [['url_key'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Назва',
            'url_key' => 'Ключ',
            'category_id' => 'Категорія',
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
    public function validateUrlKey()
    {
        return preg_match("/^[A-Za-z0-9._-]/", $this->url_key);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Items::class, ['subcategory_id' => 'id']);
    }
}
