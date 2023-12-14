<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\models\Favorite;
use app\models\GoodsImages;
use yii\bootstrap5\Html;

if (count($goods) > 0):
    ?>
    <section class="section goods__widget container-fluid">
        <h2 class="goods__subtitle">Інші товари</h2>
        <div class="goods goods--widget">
            <?php foreach ($goods as $item):
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
                        <p class="goods__price"><?= number_format($item->price, 2, '.', ' ') ?> ₴ / шт.</p>
                    </a>
                </article>
            <?php endforeach;?>
        </div>
    </section>
<?php endif; ?>