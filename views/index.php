<?php

use app\models\Category;
use app\models\Goods;
use app\models\GoodsImages;
use app\models\Subcategory;
use yii\helpers\Html;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Обране';

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="favorite">

    <h1 class="favorite__title"><?= Html::encode($this->title) ?></h1>

    <?php if (count($model) !== 0): ?>
    <div class="favorite__wrapper goods">
        <?php foreach ($model as $item):
            $id = $item->good_id;
            $good = Goods::findOne(['id' => $item->good_id]);
            $title = $good->title;
            $url_key = $good->url_key;

            if (GoodsImages::find()->where(['good_id' => $id])->count() === 0) {
                $goods_image = 'no-image.png';
            } else {
                if (GoodsImages::findOne(['good_id' => $id, 'preview' => 'Так']) !== null) {
                    $goods_image = GoodsImages::findOne(['good_id' => $id, 'preview' => 'Так'])->image;
                } else {
                    $goods_image = GoodsImages::findOne(['good_id' => $id])->image;
                }
            }
            $image_param = explode('.', $goods_image);
            ?>
            <article class="goods__item favorite__item">
                <a class="goods__link favorite__link" href="<?= Yii::$app->urlManager->createUrl(['/shop/good/' . $url_key]) ?>">
                    <picture class="favorite__image goods__image">
                        <source srcset="/img/goods/<?= $image_param[0] ?>.webp" type="image/webp">
                        <?= Html::img('@web/img/goods/' . $goods_image, ['alt' => $title, 'width' => 335, 'height' => 335]) ?>
                    </picture>
                    <h3 class="favorite__title goods__title"><?= $title ?></h3>
                </a>
                <?= Html::a('Видалити з обраного', ['delete', 'id' => $item->id], [
                    'class' => 'favorite__delete',
                    'data' => [
                        'confirm' => 'Ви впевнені, що хочете видалити цей товар з обраного?',
                        'method' => 'post',
                    ],
                ]) ?>
            </article>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
