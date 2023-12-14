<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\models\Goods;
use app\models\GoodsImages;
use yii\bootstrap5\Html;

$total_price = 0;
?>

<div class="cart-widget" id="cart-widget">
    <header class="cart-widget__header">
        <h2 class="cart-widget__title">Кошик</h2>

        <?= Html::img('@web/img/icons/close.svg', ['class' => 'cart-widget__close', 'id' => 'cart-widget-close', 'alt' => 'Закрити', 'width' => 30, 'height' => 30]) ?>
    </header>

    <div class="cart-widget__wrapper">
        <?php  if ($cart === null) : ?>
            <?= Html::img('@web/img/empty-cart.svg', ['class' => 'cart-widget__empty', 'id' => 'cart-widget-empty', 'alt' => 'Закрити', 'width' => 259, 'height' => 303]) ?>
            <p class="cart-widget__info">У вашому кошику немає товарів.</p>
        <?php else: ?>
            <?php foreach ($cart as $item):
                $good = Goods::findOne(['id' => $item->good_id]);

                $goods_image = 'no-image.png';

                if (GoodsImages::find()->where(['good_id' => $good->id])->count() > 0) {
                    if (($preview = GoodsImages::findOne(['good_id' => $good->id, 'preview' => 'Так'])) !== null) {
                        $goods_image = $preview->image;
                    } else {
                        $preview = GoodsImages::findOne(['good_id' => $good->id]);
                        $goods_image = $preview->image;
                    }
                }

                $image_param = explode('.', $goods_image);

                $total_price = $total_price + $good->price * $item->count;
                $price = number_format($good->price, 2, '.', ' ');

                ?>
                <div class="cart-widget__item cart-widget__item-<?= $item->id ?>" id="cart-item-<?= $item->id ?>">
                    <picture class="cart-widget__item-image">
                        <source srcset="/img/goods/<?= $image_param[0] ?>.webp" type="image/webp">
                        <?= Html::img('@web/img/goods/' . $goods_image, ['alt' => $good->title, 'width' => 100, 'height' => 100]) ?>
                    </picture>

                    <div class="cart-widget__item-info">
                        <a class="cart-widget__item-title" href="<?= Yii::$app->urlManager->createUrl(['/shop/good/' . $good->url_key]) ?>"><?= $good->title ?></a>

                        <div class="cart-widget__item-ctrl">
                            <p class="cart-widget__item-price"><?= $price ?> ₴ / шт.</p>
                            
                            <div class="cart-widget__item-count">
                                <span class="cart-widget__item-count-minus" <?= ($good->available === 'Ні') ? '' : 'onclick="subtractCountGoods(' . $item->id . ')"'?>>-</span>
                                <input class="cart-widget__item-count-input" type="text" id="item-count-<?= $item->id ?>" value="<?= $item->count ?>" <?= ($good->available === 'Ні') ? 'disabled' : 'oninput="changeCountGoods(' . $item->id . ')"'?> onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                <span class="cart-widget__item-count-plus" <?= ($good->available === 'Ні') ? '' : 'onclick="addCountGoods(' . $item->id . ')"'?>>+</span>
                            </div>
                        </div>

                        <a class="cart-widget__item-delete" onclick="deleteFromCart(<?= $item->id ?>)" data-cart-item="<?= $item->id ?>">Видалити</a>
                    </div>
                </div>
            <?php endforeach;?>
        <?php endif; ?>
    </div>

    <?php  if ($cart !== null) : ?>
        <div class="cart-widget__details">
            <h3 class="cart-widget__sum">
                <span>Загалом</span>
                <span class="cart-widget__total-count" data-price="<?= $total_price ?>">
                    <?= number_format($total_price, 2, '.', ' ') ?> ₴
                </span>
            </h3>
            <a class="cart-widget__order button button--inverse" href="<?= Yii::$app->urlManager->createUrl(['/order']) ?>" type="button">
                Оформити замовлення
            </a>
        </div>
    <?php endif; ?>
</div>
