<?php

namespace app\models;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "slider".
 *
 * @property int $id ID
 * @property string $title Заголовок
 * @property string $description Опис
 * @property string $page_url_key Ключ сторінки
 * @property string $image Зображення
 * @property string $imageFile Зображення
 * @property int $created_at Створено
 * @property int $updated_at Відредаговано
 */
class Slider extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'page_url_key', 'image'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 300],
            [['page_url_key'], 'string', 'max' => 25],
            [['image'], 'string', 'max' => 50],
            [['imageFile'], 'image', 'extensions' => 'jpeg, jpg, png', 'maxSize' => 1024 * 1024 * 1.5, 'minWidth' => 1000, 'minHeight' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Опис',
            'page_url_key' => 'Ключ сторінки',
            'image' => 'Зображення',
            'imageFile' => 'Зображення 1000х1000',
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
    public function upload($image_name, $image_extension)
    {
        if ($this->validate()) {
            $image = $image_name . '.' . $image_extension;
            $this->imageFile->saveAs('img/slider/' . $image);

            if ($image_extension !== 'png') {
                imagepng(
                    imagecreatefromstring(
                        file_get_contents('img/slider/' . $image)
                    ),
                    'img/slider/' . $image_name . '.png'
                );

                $image = $image_name . '.png';
                unlink('img/slider/' . $image_name . '.' . $image_extension);
            }

            $dir = '@webroot/img/slider/';
            Image::thumbnail($dir . $image, 1000, 1000)
                ->save(Yii::getAlias($dir . $image), ['quality' => 100]);

            $imagePath = 'img/slider/' . $image;
            $im = imagecreatefrompng($imagePath);
            imagepalettetotruecolor($im);
            imagealphablending($im, true);
            imagesavealpha($im, true);
            $newImagePath = str_replace("png", "webp", $imagePath);
            $quality = 100;
            imagewebp($im, $newImagePath, $quality);

            return true;
        } else {
            return false;
        }
    }
}
