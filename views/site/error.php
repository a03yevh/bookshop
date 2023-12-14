<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;

$title = $name;

$this->title = $title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => $message,
]);
?>
<section class="error section container">
    <?= Html::img('@web/img/error.svg', ['class' => 'error__img', 'alt' => Html::encode($name), 'width' => 300, 'height' => 300])?>
    <h1 class="error__title"><?= nl2br(Html::encode($name)) ?></h1>
    <p class="error__info"><?= nl2br(Html::encode($message)) ?></p>
</section>
