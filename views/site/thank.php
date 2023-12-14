<?php

use yii\helpers\Html;

$title = $name;

$this->title = $title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => $message,
]);

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<section class="thank section container">
    <?= Html::img('@web/img/thank.svg', ['class' => 'thank__img', 'alt' => Html::encode($name), 'width' => 300, 'height' => 300])?>
    <h1 class="thank__title"><?= nl2br(Html::encode($name)) ?></h1>
    <p class="thank__info"><?= nl2br(Html::encode($message)) ?></p>
</section>
