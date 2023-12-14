<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\models\Favorite;
use app\models\ItemsImages;
use yii\bootstrap5\Html;

if ($count > 0): ?>
    <nav class="footer__nav">
        <h5 class="footer__nav-title">Категорії</h5>
        <ul class="footer__nav-list">
            <?php foreach ($category as $item): ?>
                <li class="footer__nav-item">
                    <a class="footer__nav-link" href="<?= Yii::$app->urlManager->createUrl(['/guide/category/' . $item->url_key]) ?>">
                        <?= $item->title ?>
                    </a>
                </li>
            <?php endforeach;?>
            <?php if ($count > 4): ?>
                <li class="footer__nav-item">
                    <a class="footer__nav-link" href="<?= Yii::$app->urlManager->createUrl(['/guide']) ?>">
                        та інші...
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>