<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id ID
 * @property string $title Назва
 * @property string $keywords META keywords
 * @property string $description META description
 * @property string $articul Артикул
 * @property string $url_key Ключ
 * @property string $author Автор
 * @property int $year Рік
 * @property string $lang Мова
 * @property int $category_id Категорія
 * @property int $subcategory_id Підкатегорія
 * @property float $price Ціна
 * @property string $publisher Видавництво
 * @property string $genre Жанр
 * @property string $hide Відображати
 * @property string $available В наявності
 * @property int $created_at Створено
 * @property int $updated_at Відредаговано
 *
 * @property Cart[] $carts
 * @property Category $category
 * @property Favorite[] $favorites
 * @property GoodsCharacteristics[] $goodsCharacteristics
 * @property GoodsDescription[] $goodsDescriptions
 * @property GoodsImages[] $goodsImages
 * @property GoodsGenre[] $goodsGenre
 * @property Orders[] $orders
 * @property Subcategory $subcategory
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'articul', 'url_key', 'category_id', 'price'], 'required'],
            [['year', 'category_id', 'subcategory_id', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['hide', 'available'], 'string'],
            [['title', 'url_key'], 'string', 'max' => 100],
            [['publisher'], 'string', 'max' => 255],
            [['genre'], 'string'],
            [['keywords', 'description', 'author'], 'string', 'max' => 300],
            [['lang'], 'string', 'max' => 50],
            [['articul'], 'string', 'max' => 25],
            [['articul'], 'unique'],
            [['url_key'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategory::class, 'targetAttribute' => ['subcategory_id' => 'id']],
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
            'articul' => 'Артикул',
            'url_key' => 'Ключ',
            'author' => 'Автор',
            'year' => 'Рік',
            'lang' => 'Мова',
            'category_id' => 'Категорія',
            'subcategory_id' => 'Підкатегорія',
            'price' => 'Ціна',
            'publisher' => 'Видавництво',
            'genre' => 'Жанр',
            'hide' => 'Приховано',
            'available' => 'В наявності',
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
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['good_id' => 'id']);
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
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::class, ['good_id' => 'id']);
    }

    /**
     * Gets query for [[GoodsCharacteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsCharacteristics()
    {
        return $this->hasMany(GoodsCharacteristics::class, ['good_id' => 'id']);
    }

    /**
     * Gets query for [[GoodsGenre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsGenre()
    {
        return $this->hasMany(GoodsGenre::class, ['good_id' => 'id']);
    }

    /**
     * Gets query for [[GoodsDescriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsDescriptions()
    {
        return $this->hasMany(GoodsDescription::class, ['good_id' => 'id']);
    }

    /**
     * Gets query for [[GoodsImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsImages()
    {
        return $this->hasMany(GoodsImages::class, ['good_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['good_id' => 'id']);
    }

    /**
     * Gets query for [[Subcategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::class, ['id' => 'subcategory_id']);
    }
}
