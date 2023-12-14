<?php

namespace app\models;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "goods_images".
 *
 * @property int $id ID
 * @property string $image Зображення
 * @property string $imageFile Зображення
 * @property string $alt_text Альтернативний текст
 * @property string $preview Превʼю
 * @property int $good_id Товар
 * @property int $created_at Створено
 * @property int $updated_at Відредаговано
 *
 * @property Goods $good
 */
class GoodsImages extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'alt_text', 'good_id'], 'required'],
            [['preview'], 'string'],
            [['good_id', 'created_at', 'updated_at'], 'integer'],
            [['image'], 'string', 'max' => 50],
            [['image'], 'unique'],
            [['alt_text'], 'string', 'max' => 100],
            [['good_id'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::class, 'targetAttribute' => ['good_id' => 'id']],
            [['imageFile'], 'image', 'extensions' => 'jpeg, jpg, png', 'maxSize' => 1024 * 1024 * 1, 'minWidth' => 800, 'minHeight' => 800],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Зображення',
            'imageFile' => 'Зображення 800х800',
            'alt_text' => 'Альтернативний текст',
            'preview' => 'Превʼю',
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
     * @inheritdoc
     */
    public function upload($image_name, $image_extension)
    {
        if ($this->validate()) {
            $image = $image_name . '.' . $image_extension;
            $this->imageFile->saveAs('img/goods/' . $image);

            if ($image_extension !== 'png') {
                imagepng(
                    imagecreatefromstring(
                        file_get_contents('img/goods/' . $image)
                    ),
                    'img/goods/' . $image_name . '.png'
                );

                $image = $image_name . '.png';
                unlink('img/goods/' . $image_name . '.' . $image_extension);
            }

            $dir = '@webroot/img/goods/';
            Image::thumbnail($dir . $image, 800, 800)
                ->save(Yii::getAlias($dir . $image), ['quality' => 100]);

            $imagePath = 'img/goods/' . $image;
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
     * Gets query for [[Good]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Goods::class, ['id' => 'good_id']);
    }
}
