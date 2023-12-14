<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property int $id ID
 * @property string $title Назва
 * @property string|null $keywords META keywords
 * @property string|null $description META description
 * @property string $content Контент
 * @property string $url URL
 * @property int $updated_at Відредаговано
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['content'], 'string'],
            [['updated_at'], 'integer'],
            [['title', 'keywords', 'description'], 'string', 'max' => 500],
            [['url'], 'string', 'max' => 50],
            [['url'], 'unique'],
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
            'keywords' => 'META keywords',
            'description' => 'META description',
            'content' => 'Контент',
            'url' => 'URL',
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
}
