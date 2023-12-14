<?php

/** @var yii\web\View $this */

use app\models\Favorite;
use app\models\GoodsGenre;
use yii\helpers\Html;
use yii\helpers\Url;

$title = $model->title;
$keywords = $model->keywords === null ? '' : $model->keywords;
$description = $model->description === null ? '' : $model->description;

$this->title = $title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => $description,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $keywords,
]);

Yii::$app->seo->putOpenGraphTags(
    [
        'og:site_name' => Yii::$app->name,
        'og:title' => $title,
        'og:description' => $description,
        'og:image' => Url::to('@web/img/banner.jpg', true),
        'og:url' => Url::canonical(),
    ]
);

Yii::$app->seo->putGooglePlusMetaTags(
    [
        'name' => $title,
        'description' => $description,
        'image'  => Url::to('@web/img/banner.jpg', true),
    ]
);

$this->params['breadcrumbs'][] = [
    'label' => 'Магазин',
    'url' => ['index']
];

if ($category !== null) {
    $this->params['breadcrumbs'][] = [
        'label' => $category->title,
        'url' => ['category', 'id' => $category->url_key]
    ];
}

if ($subcategory !== null) {
    $this->params['breadcrumbs'][] = [
        'label' => $subcategory->title,
        'url' => ['subcategory', 'id' => $subcategory->url_key]
    ];
}


$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];

$is_size_active = false;

$this->registerCssFile("@web/css/lightbox.css", [
    'depends' => [
            '\yii\bootstrap5\BootstrapAsset'
    ],
]);
$this->registerJsFile("@web/js/lightbox.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
?>
<section class="good section container-fluid">
    <div class="good__images">
        <?php if (count($good_images) > 0): ?>
            <?php foreach ($good_images as $image):
                $image_param = explode('.', $image->image);
                ?>
                <a class="good__image-link" href="/img/goods/<?= $image->image ?>" data-lightbox="image-<?= $image->good_id ?>">
                    <picture class="good__image">
                        <source srcset="/img/goods/<?= $image_param[0] ?>.webp" type="image/webp">
                        <?= Html::img('@web/img/goods/' . $image->image, ['alt' => $image->alt_text, 'width' => 500, 'height' => 500]) ?>
                    </picture>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="good__info">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if ($model->author !== null): ?>
            <p class="good__author"><?= $model->author ?></p>
        <?php endif;?>
        <p class="good__articul"><strong>Артикул:</strong> <?= $model->articul ?></p>
        <?php if ($model->year !== null): ?>
            <p class="good__articul"><strong>Рік видання:</strong> <?= $model->year ?></p>
        <?php endif;?>
        <?php if ($model->lang !== null): ?>
            <p class="good__articul"><strong>Мова:</strong> <?= $model->lang ?></p>
        <?php endif;?>
        <p class="good__price" id="good-price-<?= $model->id ?>" data-price="<?= $model->price ?>">
            <?= number_format($model->price, 2, '.', ' ') ?> ₴ / шт.
        </p>

        <div class="good__control">
            <a class="good__button<?= $model->available === 'Так' ? '' : ' good__button--disable' ?> button" type="button" data-good-id="<?= $model->id ?>">Придбати</a>
            <?php if (!Yii::$app->user->isGuest):
            $favorite_icon = Favorite::findOne(['good_id' => $model->id, 'user_id' => Yii::$app->user->identity->id]) !== null ? 'bxs-heart' : 'bx-heart'
            ?>
                <i class="good__favorite goods__favorite bx <?= $favorite_icon ?>" data-good-id="<?= $model->id ?>"></i>
            <?php endif; ?>
        </div>

        <?php if ($model->genre !== null): ?>
            <div class="good__genre">
                <?php
                $genrises = GoodsGenre::find()->where(['good_id' => $model->id])->orderBy(['value' => SORT_ASC])->all();
                foreach ($genrises as $genre): ?>
                    <span class="shop__filters-badge">
                        <?= $genre->value ?>
                    </span>
                <?php endforeach;?>
            </div>
        <?php endif;?>

        <?php if (count($good_characteristics) > 0): ?>
            <div class="good__characteristics">
                <p class="good__characteristics-title">Характеристики</p>

                <table class="good__characteristics-tbl table table-md">
                    <tbody>
                    <?php foreach ($good_characteristics as $characteristic): ?>
                        <tr>
                            <td><?= $characteristic->parameter ?>:</td>
                            <td><?= $characteristic->value ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($good_description !== null): ?>
            <div class="good__description">
                <?= $good_description->text ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= \app\widgets\GoodsWidget::widget(['good_id' => $model->id]); ?>
