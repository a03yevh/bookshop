<?php

use app\models\GoodsImages;
use app\models\Favorite;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$title = $content->title;
$keywords = $content->keywords;
$description = $content->description;

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

$this->params['isHome'] = true;

$this->registerCssFile("@web/css/swiper-bundle.min.css", [
    'depends' => [
        '\yii\bootstrap5\BootstrapAsset'
    ],
]);
$this->registerJsFile("@web/js/swiper-bundle.min.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$this->registerJsFile("@web/js/swiper-setting.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
?>
<?php if(count($slider) > 0): ?>
    <section class="slider section swiper">
        <div class="slider__wrapper swiper-wrapper">
            <?php foreach ($slider as $slide):
                $image_param = explode('.', $slide->image);
                ?>
                <div class="slider__slide swiper-slide">
                    <picture class="slider__slide-image">
                        <source srcset="/img/slider/<?= $image_param[0] ?>.webp" type="image/webp">
                        <?= Html::img('@web/img/slider/' . $slide->image, ['alt' => $slide->title, 'width' => 1200, 'height' => 1200]) ?>
                    </picture>

                    <div class="slider__slide-info">
                        <span class="slider__slide-title"><?= $slide->title ?></span>
                        <p class="slider__slide-description"><?= $slide->description ?></p>
                        <a class="slider__slide-link" href="<?= Yii::$app->urlManager->createUrl([$slide->page_url_key]) ?>">Детально</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </section>
<?php endif; ?>

<?php if(count($categories) === 3): ?>
    <section class="section categories container-fluid">
        <div class="categories__wrapper">
            <div class="categories__item categories__item--text">
                <p>Наша мета - робити світ книг доступним для кожного. У нас ви знайдете величезний асортимент книжок на будь-який смак і вік: від класичних шедеврів до новітніх бестселерів, від дитячої літератури до наукових досліджень. Ми пильно відбираємо кожну книгу, переконуючись у її якості та цікавості, щоб пропонувати вам лише найкраще.</p>
                <a href="<?= Yii::$app->urlManager->createUrl(['/shop']) ?>">Перейти в магазин</a>
            </div>

            <div class="categories__item categories__item--empty"></div>

            <?php foreach ($categories as $category):
                $image_param = explode('.', $category->image);
                ?>
                <a class="categories__item categories__item--card" href="<?= Yii::$app->urlManager->createUrl(['/shop/category/' . $category->url_key]) ?>">
                    <picture class="categories__item-image">
                        <source srcset="/img/category/<?= $image_param[0] ?>.webp" type="image/webp">
                        <?= Html::img('@web/img/category/' . $category->image, ['alt' => $category->title, 'width' => 505, 'height' => 505]) ?>
                    </picture>

                    <h3 class="categories__item-title">
                        <?= $category->title ?>
                    </h3>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php if(count($new_goods) !== 0): ?>
    <section class="section new">
        <div class="new__wrapper">
            <h2 class="new__title">Нові товари</h2>
            <a class="new__title" href="<?= Yii::$app->urlManager->createUrl(['/shop']) ?>">Переглянути</a>

            <div class="goods-swiper swiper">
                <div class="goods-swiper__wrapper swiper-wrapper">
                    <?php foreach ($new_goods as $item):
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
                        <article class="goods-swiper__slide goods__item swiper-slide">
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
                                <p class="goods__price"><?= number_format($item->price, 2, '.', ' ') ?> ₴ / шт.</p>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <picture class="new__image">
            <source srcset="/img/new.webp" type="image/webp">
            <?= Html::img('@web/img/new.png', ['alt' => 'Нова колекція', 'width' => 1000, 'height' => 1000]) ?>
        </picture>
    </section>
<?php endif; ?>

<section class="section links container">
    <div class="links__item">
        <h4 class="links__title">Про нас</h4>
        <p class="links__info">«Книжкова вежа» - це місце, де слово стає живим, а сторінки книг розкривають світ нових уявлень, знань та емоцій.</p>
        <a class="links__link" href="<?= Yii::$app->urlManager->createUrl(['/about']) ?>">
            Детальніше
        </a>
    </div>

    <div class="links__item">
        <h4 class="links__title">Доставка і оплата</h4>
        <p class="links__info">Наш інтернет-магазин здійснює доставку по всій Україні через компанію «Нова Пошта» та «Укрпошта».</p>
        <a class="links__link" href="<?= Yii::$app->urlManager->createUrl(['/delivery-payment']) ?>">
            Детальніше
        </a>
    </div>

    <div class="links__item">
        <h4 class="links__title">Контакти</h4>
        <p class="links__info">Ви завжди можете завітати в наш магазин, або написати нам за допомогою форми зворотнього звʼязку.</p>
        <a class="links__link" href="<?= Yii::$app->urlManager->createUrl(['/contact']) ?>">
            Детальніше
        </a>
    </div>
</section>
