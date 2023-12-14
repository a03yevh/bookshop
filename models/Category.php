<?php

namespace app\models;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "category".
 *
 * @property int $id ID
 * @property string $title Назва
 * @property string $url_key Ключ
 * @property string $image Зображення
 * @property string $imageFile Зображення
 * @property int $created_at Створено
 * @property int $updated_at Відредаговано
 *
 * @property Goods[] $goods
 * @property Subcategory $subcategory
 */
class Category extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'url_key'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'image'], 'string', 'max' => 50],
            [['image'], 'unique'],
            [['url_key'], 'string', 'max' => 25],
            [['url_key'], 'unique'],
            [['imageFile'], 'image', 'extensions' => 'jpeg, jpg, png', 'maxSize' => 1024 * 1024 * 1, 'minWidth' => 512, 'minHeight' => 512],
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
            'image' => 'Зображення',
            'imageFile' => 'Зображення 512х512',
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
     * @inheritdoc
     */
    public function upload($image_name, $image_extension)
    {
        if ($this->validate()) {
            $image = $image_name . '.' . $image_extension;
            $this->imageFile->saveAs('img/category/' . $image);

            if ($image_extension !== 'png') {
                imagepng(
                    imagecreatefromstring(
                        file_get_contents('img/category/' . $image)
                    ),
                    'img/category/' . $image_name . '.png'
                );

                $image = $image_name . '.png';
                unlink('img/category/' . $image_name . '.' . $image_extension);
            }

            $dir = '@webroot/img/category/';
            Image::thumbnail($dir . $image, 512, 512)
                ->save(Yii::getAlias($dir . $image), ['quality' => 100]);

            $imagePath = 'img/category/' . $image;
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

    /**
     * Gets query for [[Goods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(Goods::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Subcategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::class, ['category_id' => 'id']);
    }
}
