<?php

/** @var yii\web\View $this */

use app\models\Favorite;
use app\models\GoodsImages;
use app\models\GoodsSizes;
use app\models\Subcategory;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

if (Yii::$app->request->get('q')) {
    $title = 'Пошук: ' . Yii::$app->request->get('q');
} else {
    if (($category === null) && ($subcategory === null)) {
        $title = 'Магазин';
    } elseif (($category !== null) && ($subcategory === null)) {
        $title = $category->title;
    } else {
        $title = $subcategory->title;
    }
}
$keywords = 'Книжкова вежа, книги, інтернет-магазин книг';
$description = 'Завітайте до Книжкової вежі - вашого надійного провідника у світі книг. Дозвольте нам допомогти вам знайти те, що розширить ваші горизонти, захопить, збагатить і зробить ваші часи більш цікавими та захоплюючими.';

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

if (Yii::$app->request->get('q')) {
    $this->params['breadcrumbs'][] = [
        'label' => $this->title,
        'url' => ['search', 'q' => Yii::$app->request->get('q')]
    ];
}

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
?>
<section class="shop section container-fluid">
    <div class="shop__filters">
        <?= Html::img('@web/img/icons/filter.svg', ['class' => 'shop__filter-icon', 'id' => 'shop-filters-toggle', 'alt' => 'Фільтри', 'width' => 25, 'height' => 25]) ?>

        <nav class="shop__filters-nav" id="shop-filter-nav">
            <?= Html::img('@web/img/icons/close.svg', ['class' => 'shop__filters-close', 'id' => 'shop-filters-close', 'alt' => 'Закрити', 'width' => 20, 'height' => 20]) ?>



            <h6 class="shop__filters-title shop__filters-title--top">Сортування</h6>
            <ul class="shop__filters-list">
                <li class="shop__filters-item">
                    <a class="shop__filters-link" href="<?= Url::current(['sort' => 'price', 'page' => 1]);?>">за зростанням ціни</a>
                </li>
                <li class="shop__filters-item">
                    <a class="shop__filters-link" href="<?= Url::current(['sort' => '-price', 'page' => 1]);?>">за зменшенням ціни</a>
                </li>
                <li class="shop__filters-item">
                    <a class="shop__filters-link" href="<?= Url::current(['sort' => 'title', 'page' => 1]);?>">за назвою А-я</a>
                </li>
                <li class="shop__filters-item">
                    <a class="shop__filters-link" href="<?= Url::current(['sort' => '-title', 'page' => 1]);?>">за назвою Я-а</a>
                </li>
            </ul>

            <h6 class="shop__filters-title">Категорії</h6>
            <ul class="shop__filters-list">
                <li class="shop__filters-item">
                    <a class="shop__filters-link" href="<?= Yii::$app->urlManager->createUrl(['/shop/index']) ?>">
                        Всі товари
                    </a>
                </li>
                <?php foreach ($categories as $category): ?>
                    <li class="shop__filters-item">
                        <?php if (Subcategory::findOne(['category_id' => $category->id]) !== null): ?>
                            <a class="shop__filters-link shop__filters-link--more">
                                <?= $category->title ?>
                            </a>

                            <ul class="shop__filters-list shop__filters-list--sub">
                                <li class="shop__filters-item shop__filters-item--sub">
                                    <a class="shop__filters-link" href="<?= Yii::$app->urlManager->createUrl(['/shop/category/' . $category->url_key]) ?>">
                                        Всі товари категорії
                                    </a>
                                </li>
                                <?php
                                $subcategories = Subcategory::find()->where(['category_id' => $category->id])->orderBy(['title' => SORT_ASC])->all();

                                foreach ($subcategories as $subcategory):
                                    ?>
                                    <li class="shop__filters-item shop__filters-item--sub">
                                        <a class="shop__filters-link" href="<?= Yii::$app->urlManager->createUrl(['/shop/subcategory/' . $subcategory->url_key]) ?>">
                                            <?= $subcategory->title ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                </li>
                            </ul>
                        <?php else: ?>
                            <a class="shop__filters-link" href="<?= Yii::$app->urlManager->createUrl(['/shop/category/' . $category->url_key]) ?>">
                                <?= $category->title ?>
                            </a>
                        <?php endif;?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h6 class="shop__filters-title">Видавництва</h6>
            <div class="shop__filters-badges">
                <?php foreach ($publishers as $publisher): ?>
                    <a class="shop__filters-badge" href="<?= Url::current(['publisher' => $publisher->publisher, 'page' => 1]);?>">
                        <?= $publisher->publisher ?>
                    </a>
                <?php endforeach;?>
            </div>

            <?php if (count($genrises) > 0):?>
                <h6 class="shop__filters-title">Жанри</h6>
                <div class="shop__filters-badges">
                    <?php foreach ($genrises as $genre): ?>
                        <a class="shop__filters-badge" href="<?= Url::current(['genre' => $genre->value, 'page' => 1]);?>">
                            <?= $genre->value ?>
                        </a>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        </nav>
    </div>

    <div class="shop__content">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (count($model) !== 0): ?>
            <div class="goods">
                <?php foreach ($model as $item):
                    $goods_image = 'no-image.png';

                    if (GoodsImages::find()->where(['good_id' => $item->id])->count() > 0) {
                        if (($preview = GoodsImages::findOne(['good_id' => $item->id, 'preview' => 'Так'])) !== null) {
                            $goods_image = $preview->image;
                        } else {
                            $preview = GoodsImages::findOne(['good_id' => $item->id]);
                            $goods_image = $preview->image;
                        }
                    }

                    $image_param = explode('.', $goods_image);
                    ?>
                    <article class="goods__item">
                        <?php if (!Yii::$app->user->isGuest):
                            $favorite_icon = Favorite::findOne(['good_id' => $item->id, 'user_id' => Yii::$app->user->identity->id]) !== null ? 'bxs-heart' : 'bx-heart'
                            ?>
                            <i class="goods__favorite bx <?= $favorite_icon ?>" data-good-id="<?= $item->id ?>"></i>
                        <?php endif; ?>
                        <a class="goods__link" href="<?= Yii::$app->urlManager->createUrl(['/shop/good/' . $item->url_key]) ?>">
                            <picture class="goods__image">
                                <source srcset="/img/goods/<?= $image_param[0] ?>.webp" type="image/webp">
                                <?= Html::img('@web/img/goods/' . $goods_image, ['alt' => $item->title, 'width' => 335, 'height' => 335]) ?>
                            </picture>
                            <h3 class="goods__title"><?= $item->title ?></h3>
                            <p class="goods__price" id="good-price-<?= $item->id ?>" data-price="<?= $item->price ?>">
                                <?= number_format($item->price, 2, '.', ' ') ?> ₴ / шт.
                            </p>
                        </a>
                        <div class="goods__control">
                            <a class="goods__button<?= $item->available === 'Так' ? '' : ' goods__button--disable' ?> button" data-good-id="<?= $item->id ?>">Придбати</a>
                        </div>
                    </article>
                <?php endforeach;?>
            </div>
        <?php else: ?>
            <h3>За обраними критеріями нічого не знайдено.</h3>
        <?php endif; ?>
        <?php
        if ($pages !== null) {
            echo LinkPager::widget([
                'pagination' => $pages,
                'registerLinkTags' => true,
                'prevPageLabel' => false,
                'nextPageLabel' => false,
                'lastPageLabel' => '&gt;',
                'firstPageLabel' => '&lt;',
                'options' => [
                    'tag' => 'ul',
                    'class' => 'shop__pagination pagination',
                ],
                'linkContainerOptions' => [
                    'class' => 'page-item'
                ],
                'linkOptions' => [
                    'class' => 'page-link'
                ],
                'activePageCssClass' => [
                    'class' => 'active'
                ],
            ]);
        }
        ?>
    </div>
</section>
