<?php

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

$this->params['breadcrumbs'][] = [
    'label' => $title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<section class="section container">
    <?= $content->content ?>
</section>
