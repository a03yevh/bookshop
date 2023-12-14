<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\models\Cart;
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Yii::$app->name . ' &bull; ' . Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="header<?= isset($this->params['isHome']) ? ' header--home': '' ?>" id="header">
    <div class="header__container container-fluid">
        <div class="header__menu">
            <nav class="nav">
                <div class="hamburger" id="nav-toggle">
                    <span class="hamburger__ham hamburger__ham--top"></span>
                    <span class="hamburger__ham hamburger__ham--middle"></span>
                    <span class="hamburger__ham hamburger__ham--bottom"></span>
                </div>
                <ul class="nav__items nav__items--main" id="nav-items" itemscope itemtype="http://schema.org/SiteNavigationElement">
                    <li class="nav__item" itemprop="name">
                        <a class="nav__link" itemprop="url" href="<?= Yii::$app->urlManager->createUrl(['/site']) ?>">
                            Головна
                        </a>
                    </li>
                    <li class="nav__item" itemprop="name">
                        <a class="nav__link" itemprop="url" href="<?= Yii::$app->urlManager->createUrl(['/shop']) ?>">
                            Магазин
                        </a>
                    </li>
                    <li class="nav__item" itemprop="name">
                        <a class="nav__link" itemprop="url" href="<?= Yii::$app->urlManager->createUrl(['/about']) ?>">
                            Про нас
                        </a>
                    </li>
                    <li class="nav__item" itemprop="name">
                        <a class="nav__link" itemprop="url" href="<?= Yii::$app->urlManager->createUrl(['/delivery-payment']) ?>">
                            Доставка і оплата
                        </a>
                    </li>
                    <li class="nav__item" itemprop="name">
                        <a class="nav__link" itemprop="url" href="<?= Yii::$app->urlManager->createUrl(['/contact']) ?>">
                            Контакти
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="brand" itemscope itemtype="http://schema.org/Organization">
                <a class="brand__link" itemprop="url" href="/" rel="home">
                    <svg class="brand__img" id="bries-logo" data-name="bries-logo"  width="90" height="25" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1024 293"itemprop="logo">
                        <g  id="bries-logo-body" data-name="bries-logo-body">
                            <g id="icon">
                                <g>
                                    <g>
                                        <path d="M250.7,196.6c-1.1,0-2.3-0.2-3.4-0.7c-3.3-1.4-5.4-4.6-5.4-8.1v-25.6c0-8.9-3.5-17.1-10-23.3
					c-6.4-6.1-14.8-9.3-23.7-8.8L10,130.6c0,0,0,0,0,0c-4,0-7.6-2.4-9.2-6.1c-1.5-3.7-0.7-8,2.2-10.8c0.1-0.1,0.2-0.2,0.4-0.3
					l89.6-77.8c7.3-7.2,17.4-11.3,28.1-11.3h176.7c29.5,0,53.5,24,53.5,53.5c0,14.3-5.6,27.7-15.7,37.8L256.9,194
					C255.2,195.7,253,196.6,250.7,196.6z M210.1,114.8c11.9,0,23.4,4.6,32.3,13.1c9.5,9,14.7,21.2,14.7,34.3v10.2l67.6-67.6
					c7.2-7.2,11.2-16.9,11.2-27.1c0-21.1-17.2-38.3-38.3-38.3H120.9c-6.7,0-13,2.6-17.7,7.3L24,115.4l183.8-0.5
					C208.6,114.8,209.4,114.8,210.1,114.8z"/>
                                        <path d="M239.1,199.5H8.7c-4.2,0-7.6-3.4-7.6-7.6c0-4.2,3.4-7.6,7.6-7.6h230.3c1.4,0,2.3-0.1,2.8-0.2l0-2.6
					c0-4.2,3.4-7.6,7.6-7.6c4.2,0,7.6,3.4,7.6,7.6v3.1C257.1,188,255.8,199.5,239.1,199.5z"/>
                                        <path d="M200.8,166.2H30.9c-4.2,0-7.6-3.4-7.6-7.6c0-4.2,3.4-7.6,7.6-7.6h169.9c4.2,0,7.6,3.4,7.6,7.6
					C208.4,162.8,205,166.2,200.8,166.2z"/>
                                    </g>
                                    <g>
                                        <path d="M272.1,266c-1.1,0-2.3-0.2-3.4-0.7c-3.3-1.4-5.4-4.6-5.4-8.1v-25.6c0-8.9-3.5-17.1-10-23.3c-6.4-6.1-14.9-9.3-23.7-8.8
					L31.3,200c0,0,0,0,0,0c-4.2,0-7.6-3.4-7.6-7.6c0-4.2,3.4-7.6,7.6-7.6l197.9-0.5c12.7-0.6,25.1,4,34.6,13
					c9.5,9,14.7,21.2,14.7,34.3v10.2l67.6-67.6c7.1-7.1,11.2-17,11.2-27.1c0-15.4-9.2-29.3-23.4-35.3c-3.9-1.6-5.7-6.1-4-9.9
					c1.6-3.9,6.1-5.7,9.9-4c19.9,8.4,32.7,27.7,32.7,49.3c0,14.3-5.6,27.7-15.7,37.8l-78.5,78.5C276.6,265.1,274.4,266,272.1,266z"
                                        />
                                        <path d="M260.4,268.8H14.1c-4.2,0-7.6-3.4-7.6-7.6s3.4-7.6,7.6-7.6h246.3c1.4,0,2.3-0.1,2.9-0.2l0-2.6c0-4.2,3.4-7.6,7.6-7.6
					c4.2,0,7.6,3.4,7.6,7.6v3.1C278.5,257.4,277.2,268.8,260.4,268.8z"/>
                                        <path d="M222.2,235.6H36.3c-4.2,0-7.6-3.4-7.6-7.6c0-4.2,3.4-7.6,7.6-7.6h185.9c4.2,0,7.6,3.4,7.6,7.6
					C229.8,232.2,226.4,235.6,222.2,235.6z"/>
                                    </g>
                                </g>
                            </g>
                            <g id="text">
                                <path d="M488,74.8l16.6,36.9c3.4,7.3,7.8,5.8,7.8,9.4c0,1.7-1.3,2.3-4.3,2.3h-12.4c-3.5,0-5-0.6-5-2.5c0-2.8,4.8-2.9,2.2-8.9
			l-13-29.6l-15.2,14.1v12.1c0,11.1,5.8,8.4,5.8,12.5c0,1.7-1.3,2.3-5,2.3h-12.7c-3.5,0-5-0.6-5-2.3c0-4.1,6-1.4,6-12.5V71.9
			c0-11.1-5.8-8.4-5.8-12.5c0-1.7,1.3-2.3,5-2.3h12.7c3.5,0,5,0.6,5,2.3c0,4.1-6,1.4-6,12.5v17.4l23.5-21.9c5.5-5.1-1.1-4.6-1.1-7.9
			c0-1.8,1.3-2.4,3.6-2.4h10.8c3.4,0,5,0.6,5,2.3c0,3.7-3.9,1.9-10.5,8L488,74.8z"/>
                                <path d="M577.3,108.6c0,11.1,5.7,8.4,5.7,12.5c0,1.7-1.3,2.3-4.9,2.3h-12.8c-3.4,0-4.9-0.6-4.9-2.3c0-4.1,5.9-1.4,5.9-12.5V95
			c0-4.3,0-4.3-16.5-4.3c-17.2,0-17.2,0-17.2,4.3v13.5c0,11.1,5.8,8.4,5.8,12.5c0,1.7-1.3,2.3-5,2.3h-12.7c-3.5,0-5-0.6-5-2.3
			c0-4.1,6-1.4,6-12.5V71.9c0-11.1-5.8-8.4-5.8-12.5c0-1.7,1.3-2.3,5-2.3h12.7c3.5,0,5,0.6,5,2.3c0,4.1-6,1.4-6,12.5v9.5
			c0,4.3,0,4.3,17.3,4.3c16.4,0,16.4,0,16.4-4.3v-9.5c0-11.1-5.7-8.4-5.7-12.5c0-1.7,1.3-2.3,4.9-2.3h12.8c3.4,0,4.9,0.6,4.9,2.3
			c0,4.1-5.9,1.4-5.9,12.5V108.6z"/>
                                <path d="M595,123.3c-3.5,0-5-0.6-5-2.3c0-3.4,4.8-2.5,5.7-8c0.2-1.1,0.3-2.2,0.3-3.2V70.6c0-1-0.1-2.1-0.3-3.2
			c-0.9-5.9-5.5-4.4-5.5-8c0-1.7,1.3-2.3,5-2.3h12.7c3.5,0,5,0.6,5,2.3c0,3.4-4.8,2.4-5.7,8c-0.2,1.1-0.3,2.2-0.3,3.2v32.4L640.5,70
			c0.9-0.9,1.2-1.7,1-2.8c-0.9-5.2-5.5-4.6-5.5-7.8c0-1.7,1.3-2.3,4.9-2.3h12.8c3.4,0,4.9,0.6,4.9,2.3c0,3.4-4.7,2.4-5.6,8
			c-0.2,1.1-0.3,2.2-0.3,3.2v39.2c0,1,0.1,2.1,0.3,3.2c0.9,5.9,5.4,4.4,5.4,8c0,1.7-1.3,2.3-4.9,2.3h-12.8c-3.4,0-4.9-0.6-4.9-2.3
			c0-3.4,4.7-2.5,5.6-8c0.2-1.1,0.3-2.2,0.3-3.2v-34L608.2,109c-0.9,0.9-1.2,1.7-1,2.9c0.9,6.6,5.6,5.6,5.6,9.1c0,1.7-1.3,2.3-5,2.3
			H595z"/>
                                <path d="M738,74.7l16.7,36.9c3.4,7.3,7.8,5.8,7.8,9.4c0,1.7-1.3,2.3-4.3,2.3h-12.4c-3.5,0-5-0.6-5-2.5c0-2.8,4.8-2.9,2.2-8.9
			l-13.1-29.7l-12.3,11.2v15.2c0,11.1,5.4,8.4,5.4,12.5c0,1.7-1.3,2.3-4.9,2.3H706c-3.4,0-4.9-0.6-4.9-2.3c0-4.1,5.6-1.4,5.6-12.5
			V92.8L695,82.2L682,111.9c-2.6,6,2.2,6.1,2.2,8.9c0,1.9-1.5,2.5-5,2.5h-12.4c-2.9,0-4.3-0.6-4.3-2.3c0-3.6,4.4-2.1,7.8-9.4
			L687,74.7l-8-7.3c-6.6-6.1-10.5-4.4-10.5-8c0-1.7,1.6-2.3,5-2.3h11.3c2.3,0,3.6,0.6,3.6,2.4c0,3.3-6.6,2.8-1.1,7.9l19.5,17.8V71.9
			c0-11.1-5.4-8.4-5.4-12.5c0-1.7,1.3-2.3,4.9-2.3h12.1c3.4,0,4.9,0.6,4.9,2.3c0,4.1-5.6,1.4-5.6,12.5v13.9l20.1-18.4
			c5.5-5-1.1-4.5-1.1-7.9c0-1.8,1.3-2.4,3.6-2.4h11.3c3.4,0,5,0.6,5,2.3c0,3.7-3.9,1.9-10.5,8L738,74.7z"/>
                                <path d="M806,74.8l16.6,36.9c3.4,7.3,7.8,5.8,7.8,9.4c0,1.7-1.3,2.3-4.3,2.3h-12.4c-3.5,0-5-0.6-5-2.5c0-2.8,4.8-2.9,2.2-8.9
			l-13-29.6l-15.2,14.1v12.1c0,11.1,5.8,8.4,5.8,12.5c0,1.7-1.3,2.3-5,2.3h-12.7c-3.5,0-5-0.6-5-2.3c0-4.1,6-1.4,6-12.5V71.9
			c0-11.1-5.8-8.4-5.8-12.5c0-1.7,1.3-2.3,5-2.3h12.7c3.5,0,5,0.6,5,2.3c0,4.1-6,1.4-6,12.5v17.4l23.5-21.9c5.5-5.1-1.1-4.6-1.1-7.9
			c0-1.8,1.3-2.4,3.6-2.4h10.8c3.4,0,5,0.6,5,2.3c0,3.7-3.9,1.9-10.5,8L806,74.8z"/>
                                <path d="M829.2,92.8c0-20.2,14.8-36.6,35.1-36.6c18.8,0,30.9,13.8,30.9,32c0,20.6-14.3,36.1-34.9,36.1
			C842,124.3,829.2,111.1,829.2,92.8z M884.4,94.4c0-16.6-9.3-32.3-24.1-32.3c-13.2,0-20.1,11.4-20.1,23c0,17.4,9.4,32.8,24.6,32.8
			C878,117.8,884.4,106.8,884.4,94.4z"/>
                                <path d="M956.3,102c0,14-10.8,21.3-29,21.3h-19.7c-3.5,0-5-0.4-5-2.3c0-4.3,6-0.9,6-12.2V71.6c0-11.4-6-7.9-6-12.2
			c0-1.9,1.5-2.3,5-2.3h17.3c14.4,0,23.5,4.5,23.6,14.5c0,5.7-3.3,10.3-10.1,12.3C949.6,85.9,956.3,92.8,956.3,102z M919.5,79.6
			c0,2.1,2.7,2,5.2,2c9,0,12.6-2.8,12.6-8.6c0-6.2-5.1-10.8-12.9-10.8c-3.2,0-4.9,0.6-4.9,3.4V79.6z M944.1,104.1
			c0-10-7.1-17.1-19.9-17.1c-4.2,0-4.7,1-4.7,3.3v21.3c0,4.6,1.1,6.6,7.6,6.6C938.5,118.2,944.1,114.1,944.1,104.1z"/>
                                <path d="M972.8,111.7c-2.9,7.6,2.4,6.2,2.4,9.4c0,1.8-1.7,2.3-3.9,2.3h-8.1c-2.6,0-4.4-0.5-4.4-2.2c0-3.3,4.9-1.9,7.9-9.5
			l17.4-43.9c2.3-5.7-3.2-5.1-3.2-8.4c0-1.5,0.9-2.3,2.8-2.3h9.6c1.5,0,2.5,0.7,3,2.1l20.6,52.3c3.1,7.8,7,6.2,7,9.5
			c0,1.8-1.3,2.4-4.8,2.4H1006c-2.6,0-4.2-0.6-4.2-2.2c0-3.4,6.1-2.3,3.1-9.6l-1.8-4.7c-1.1-2.8-1.1-2.8-14-2.8
			c-13.3,0-13.3,0-14.4,2.7L972.8,111.7z M999.1,96.5l-10.2-26l-10.1,26c-0.9,2.5-0.9,2.5,10.5,2.5
			C1000.1,98.9,1000.1,98.9,999.1,96.5z"/>
                                <path d="M501.5,215.6c0,14-10.8,21.3-29,21.3h-19.7c-3.5,0-5-0.4-5-2.3c0-4.3,6-0.9,6-12.2v-37.3c0-11.4-6-7.9-6-12.2
			c0-1.9,1.5-2.3,5-2.3h17.3c14.4,0,23.5,4.5,23.6,14.5c0,5.7-3.3,10.3-10.1,12.3C494.8,199.4,501.5,206.3,501.5,215.6z
			 M464.7,193.1c0,2.1,2.7,2,5.2,2c9,0,12.6-2.8,12.6-8.6c0-6.2-5.1-10.8-12.9-10.8c-3.2,0-4.9,0.6-4.9,3.4V193.1z M489.3,217.6
			c0-10-7.1-17.1-19.9-17.1c-4.2,0-4.7,1-4.7,3.3v21.3c0,4.6,1.1,6.6,7.6,6.6C483.7,231.7,489.3,227.6,489.3,217.6z"/>
                                <path d="M558.8,222.4c-0.3,4.9-0.8,8.1-1.5,10.9c-0.7,2.5-1.8,3.6-7.8,3.6h-37.2c-3.5,0-5-0.4-5-2.3c0-4.3,6-0.9,6-12.2v-37.3
			c0-11.4-6-7.9-6-12.2c0-1.9,1.5-2.3,5-2.3l35.8-0.1c5.5,0,6.5,0.6,7.4,3.1c0.9,2.6,1.8,5.8,2.5,9.9c0.4,2.2,0.3,3.6-1.2,4.1
			c-1.7,0.5-2.7-0.5-4.2-2.9c-3.5-6-7.5-9-13.9-9h-4.8c-8.3,0-9.6,1.3-9.6,4.4v10.5c0,4.3,2.6,4.6,6.7,4.6h1.8
			c8.8,0,7.8-3.1,10.7-3.1c1.5,0,2.2,0.9,2.6,2.9l2.1,9.4c0.8,3.5,0.4,4.3-1.2,4.7c-3.9,0.9-4.4-8.8-14.2-8.9H531
			c-4.2,0-6.7,0.4-6.7,4.6v22.3c0,3.2,1.3,4.5,9.9,4.5l6.8-0.1c7.4,0,9.2-3.1,12-9.4c1.5-3.2,2.6-4,4.1-3.7
			C558.7,219,558.9,220.3,558.8,222.4z"/>
                                <path d="M638.1,188.2l16.7,36.9c3.4,7.3,7.8,5.8,7.8,9.4c0,1.7-1.3,2.3-4.3,2.3h-12.4c-3.5,0-5-0.6-5-2.5c0-2.8,4.8-2.9,2.2-8.9
			L630,195.7l-12.3,11.2v15.2c0,11.1,5.4,8.4,5.4,12.5c0,1.7-1.3,2.3-4.9,2.3h-12.1c-3.4,0-4.9-0.6-4.9-2.3c0-4.1,5.6-1.4,5.6-12.5
			v-15.8l-11.6-10.6l-13.1,29.7c-2.6,6,2.2,6.1,2.2,8.9c0,1.9-1.5,2.5-5,2.5h-12.4c-2.9,0-4.3-0.6-4.3-2.3c0-3.6,4.4-2.1,7.8-9.4
			l16.7-36.9l-8-7.3c-6.6-6.1-10.5-4.4-10.5-8c0-1.7,1.6-2.3,5-2.3h11.3c2.3,0,3.6,0.6,3.6,2.4c0,3.3-6.6,2.8-1.1,7.8l19.5,17.8
			v-13.2c0-11.1-5.4-8.4-5.4-12.5c0-1.7,1.3-2.3,4.9-2.3h12.1c3.4,0,4.9,0.6,4.9,2.3c0,4.1-5.6,1.4-5.6,12.5v13.9l20.1-18.4
			c5.5-5-1.1-4.5-1.1-7.8c0-1.8,1.3-2.4,3.6-2.4h11.3c3.4,0,5,0.6,5,2.3c0,3.7-3.9,1.9-10.5,8L638.1,188.2z"/>
                                <path d="M676.6,225.2c-2.9,7.6,2.4,6.2,2.4,9.4c0,1.8-1.7,2.3-3.9,2.3h-8.1c-2.6,0-4.4-0.5-4.4-2.2c0-3.3,4.9-1.9,7.9-9.5
			l17.4-43.9c2.3-5.7-3.2-5.1-3.2-8.4c0-1.5,0.9-2.3,2.8-2.3h9.6c1.5,0,2.5,0.7,3,2.1l20.6,52.3c3.1,7.8,7,6.2,7,9.5
			c0,1.8-1.3,2.4-4.8,2.4h-13.1c-2.6,0-4.2-0.6-4.2-2.2c0-3.4,6.1-2.3,3.1-9.6l-1.8-4.7c-1.1-2.8-1.1-2.8-14-2.8
			c-13.3,0-13.3,0-14.4,2.7L676.6,225.2z M702.9,210l-10.2-26l-10.1,26c-0.9,2.5-0.9,2.5,10.5,2.5
			C703.8,212.4,703.8,212.4,702.9,210z"/>
                            </g>
                        </g>
                    </svg>
                    <span class="brand__title" itemprop="name"><?= Yii::$app->name ?></span>
                </a>
            </div>
        </div>

        <div class="header__tools">
            <nav class="nav nav--tools">
                <ul class="nav__items">
                    <li class="nav__item">
                        <a class="nav__link" id="search-active">
                            <span class="nav__link-text">Пошук</span>
                            <svg class="nav__link-icon" xmlns="http://www.w3.org/2000/svg" version="1.1" width="24" height="24" viewBox="0 0 512 512">
                                <g>
                                    <path d="M225.474,0C101.151,0,0,101.151,0,225.474c0,124.33,101.151,225.474,225.474,225.474
			c124.33,0,225.474-101.144,225.474-225.474C450.948,101.151,349.804,0,225.474,0z M225.474,409.323
			c-101.373,0-183.848-82.475-183.848-183.848S124.101,41.626,225.474,41.626s183.848,82.475,183.848,183.848
			S326.847,409.323,225.474,409.323z"/>
                                </g>
                                <g>
                                    <path d="M505.902,476.472L386.574,357.144c-8.131-8.131-21.299-8.131-29.43,0c-8.131,8.124-8.131,21.306,0,29.43l119.328,119.328
			c4.065,4.065,9.387,6.098,14.715,6.098c5.321,0,10.649-2.033,14.715-6.098C514.033,497.778,514.033,484.596,505.902,476.472z"/>
                                </g>
                            </svg>
                        </a>
                    </li>
                    <li class="nav__item">
                        <a class="nav__link" id="account-active">
                            <span class="nav__link-text">Акаунт</span>
                            <svg class="nav__link-icon" xmlns="http://www.w3.org/2000/svg" version="1.1" width="24" height="24" viewBox="0 0 512 512">
                                <g>
                                    <path d="M512,255.9c0,141.4-114.6,256-256,256l0,0c-141.4,0-256-114.6-256-256c0,0,0,0,0,0c0-141.4,114.6-256,256-256c0,0,0,0,0,0 C397.4-0.1,512,114.5,512,255.9L512,255.9z M272.8,256.8c32.8,3.1,62.6,14.2,89.3,33.2c6.2,4.4,12.2,9.2,17.8,14.4 c24.4,22.5,41.5,50,51.4,82.4c0.2,0.6,0.5,0.7,0.9,0.1c23.8-32.3,37.8-68.4,42.1-108.1c0.8-7.5,1.2-15.1,1.2-22.8 c-0.3-46.8-13.8-89.1-40.5-126.9c-4.5-6.3-9.2-12.3-14.1-18c-20.2-23-44.2-41-72-54c-35.2-16.4-72.4-23-111.7-19.6 c-35.1,3-67.6,13.8-97.4,32.5c-26.5,16.6-48.3,37.5-65.4,62.9c-20.4,30.2-32.6,63.6-36.5,100c-0.8,7.5-1.2,15.2-1.2,22.8 c0.2,48,14.6,91.7,43.3,131.2c0.4,0.5,0.6,0.5,0.8-0.1c8.1-26.1,20.8-49.1,38.2-68.8c4.9-5.6,10.3-10.9,16.2-16.1 c32.7-28.7,70.9-43.9,114.8-45.6C257.7,255.9,265.3,256.1,272.8,256.8z M356.7,332.5c-22.2-21.2-48.6-34.1-79-38.7 c-7.6-1.1-15.2-1.7-22.8-1.6c-23.3,0.1-45.2,5.5-65.7,16.1c-32.5,16.9-55.7,42.6-69.4,77.1c-4.5,11.2-7.4,22.3-8.7,33.4 c-0.1,1.1,0.3,2.2,1.2,2.9c38.1,32.1,81.3,49.8,129.5,53.1c7.6,0.5,15.2,0.6,22.8,0.3c51.3-2.2,96.6-20.2,136-54.1 c0.4-0.3,0.6-0.8,0.5-1.3C396.1,385.2,381.3,356.1,356.7,332.5z"/>
                                    <path d="M347.4,146.2c0,50.5-40.9,91.4-91.4,91.4s-91.4-40.9-91.4-91.4s40.9-91.4,91.4-91.4C306.5,54.9,347.4,95.8,347.4,146.2z M310.8,146.3c0-30.3-24.5-54.8-54.8-54.8c-30.3,0-54.8,24.5-54.8,54.8l0,0c0,30.3,24.5,54.8,54.8,54.8S310.8,176.5,310.8,146.3z"
                                    />
                                </g>
                            </svg>
                        </a>
                    </li>
                    <li class="nav__item">
                        <a class="nav__link nav__link--cart nav__link--cart-user" id="cart-active">
                            <span class="nav__link-text">Кошик</span>
                            <span class="nav__link-count" id="cart-count"><?= Cart::find()->where(['user_key' => Yii::$app->params['user_key']])->count()?></span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <form class="search-form" action="/shop/search"  id="search-form">
        <svg class="search-form__search-icon" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
            <g>
                <path d="M3.1,493.8l15.1,15.1c4.2,4.2,10.9,4.2,15.1,0L182,360.1c34.8,28.2,79.1,45.2,127.3,45.2c111.8,0,202.7-90.9,202.7-202.7 S421.1,0,309.3,0S106.7,90.9,106.7,202.7c0,48.2,17,92.5,45.2,127.3L3.1,478.7C-1,482.9-1,489.6,3.1,493.8z M149.3,202.7 c0-88.2,71.8-160,160-160s160,71.8,160,160s-71.8,160-160,160S149.3,290.9,149.3,202.7z"></path>
            </g>
        </svg>
        <input class="search-form__input" id="search-form-input" type="text" name="q" placeholder="Пошук" autocomplete="off">
        <?= Html::img('@web/img/icons/close.svg', ['class' => 'search-form__close', 'id' => 'search-form-close', 'alt' => 'Close', 'width' => 30, 'height' => 30]) ?>
    </form>

    <?= \app\widgets\AccountWidget::widget() ?>

    <?= \app\widgets\CartWidget::widget() ?>
</header>

<main class="main" role="main">
    <?php if (!empty($this->params['breadcrumbs'])): ?>
        <?= \app\widgets\BreadcrumbsWidget::widget([
            'options' => [
                'class' => 'breadcrumb container-fluid',
            ],
            'homeLink' => [
                'label' => 'Головна',
                'url' => ['/site/index'],
                'class' => 'home',
                'template' => '<li>{link}</li>',
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'itemTemplate' => '<li>{link}</li>',
            'activeItemTemplate' => '<li class="active">{link}</li>',
            'tag' => 'ul',
            'encodeLabels' => false
        ]);
        ?>
    <?php endif ?>
    <?= Alert::widget() ?>
    <div class="container user-panel">
        <nav class="user-panel__nav">
            <header class="user-panel__header">
                <?= Html::img('@web/img/icons/user.svg', ['class' => 'user-panel__header-ava', 'alt' => 'Аватар користувача', 'width' => 45, 'height' => 45]) ?>

                <div class="user-panel__header-info">
                    <h4 class="user-panel__header-name">
                        <?= Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name ?>
                    </h4>
                    <p class="user-panel__header-email">
                        <?= Yii::$app->user->identity->email ?>
                    </p>
                </div>
            </header>

            <ul class="user-panel__list">
                <?php if (Yii::$app->user->can('client')) : ?>
                <li class="user-panel__item">
                    <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/user/profile']) ?>">
                        <i class="bx bx-user-circle"></i>
                        Профіль
                    </a>
                </li>
                <li class="user-panel__item">
                    <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/favorite/index']) ?>">
                        <i class="bx bx-heart"></i>
                        Обране
                    </a>
                </li>
                <?php endif; ?>
                <?php if (Yii::$app->user->can('admin')) : ?>
                    <li class="user-panel__item user-panel__item--hr">
                        <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/user/index']) ?>">
                            <i class="bx bx-group"></i>
                            Всі користувачі
                        </a>
                    </li>
                    <li class="user-panel__item">
                        <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/user/managers']) ?>">
                            <i class="bx bx-user-pin"></i>
                            Менеджери
                        </a>
                    </li>
                    <li class="user-panel__item">
                        <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/user/banned']) ?>">
                            <i class="bx bx-lock"></i>
                            Чорний список
                        </a>
                    </li>
                    <li class="user-panel__item user-panel__item--hr">
                        <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/contact/list']) ?>">
                            <i class="bx bx-envelope-open"></i>
                            Контакти
                        </a>
                    </li>
                    <li class="user-panel__item">
                        <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/content/index']) ?>">
                            <i class="bx bx-spreadsheet"></i>
                            Контент
                        </a>
                    </li>
                    <li class="user-panel__item">
                        <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/slider/index']) ?>">
                            <i class="bx bx-carousel"></i>
                            Слайдер
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (Yii::$app->user->can('manager')) : ?>
                    <li class="user-panel__item user-panel__item--hr">
                        <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/category/index']) ?>">
                            <i class="bx bx-align-left"></i>
                            Категорії
                        </a>
                    </li>
                    <li class="user-panel__item">
                        <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/goods/index']) ?>">
                            <i class="bx bx-package"></i>
                            Товари
                        </a>
                    </li>
                    <li class="user-panel__item">
                        <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/orders/all']) ?>">
                            <i class="bx bx-basket"></i>
                            Замовлення клієнтів
                        </a>
                    </li>
                <?php endif; ?>
                <li class="user-panel__item user-panel__item--hr">
                    <a class="user-panel__link" href="<?= Yii::$app->urlManager->createUrl(['/site/logout']) ?>">
                        <i class="bx bx-exit"></i>
                        Вийти
                    </a>
                </li>
            </ul>
        </nav>
        <div class="user-panel__content">
            <?= $content ?>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="footer__content container-fluid">
        <div class="footer__links">
            <nav class="footer__nav footer__nav--menu">
                <h5 class="footer__nav-title">Меню</h5>
                <ul class="footer__nav-list">
                    <li class="footer__nav-item">
                        <a class="footer__nav-link" href="<?= Yii::$app->urlManager->createUrl(['/site']) ?>">
                            Головна
                        </a>
                    </li>
                    <li class="footer__nav-item">
                        <a class="footer__nav-link" href="<?= Yii::$app->urlManager->createUrl(['/shop']) ?>">
                            Магазин
                        </a>
                    </li>
                    <li class="footer__nav-item">
                        <a class="footer__nav-link" href="<?= Yii::$app->urlManager->createUrl(['/about']) ?>">
                            Про нас
                        </a>
                    </li>
                    <li class="footer__nav-item">
                        <a class="footer__nav-link" href="<?= Yii::$app->urlManager->createUrl(['/delivery-payment']) ?>">
                            Доставка і оплата
                        </a>
                    </li>
                    <li class="footer__nav-item">
                        <a class="footer__nav-link" href="<?= Yii::$app->urlManager->createUrl(['/contact']) ?>">
                            Контакти
                        </a>
                    </li>
                </ul>
            </nav>

            <?= \app\widgets\CategoryWidget::widget() ?>

            <nav class="footer__nav">
                <h5 class="footer__nav-title">Користувачу</h5>
                <ul class="footer__nav-list">
                    <li class="footer__nav-item">
                        <a class="footer__nav-link" href="<?= Yii::$app->urlManager->createUrl(['/user/profile']) ?>">
                            Мої дані
                        </a>
                    </li>
                    <li class="footer__nav-item">
                        <a class="footer__nav-link" href="<?= Yii::$app->urlManager->createUrl(['/favorite']) ?>">
                            Обране
                        </a>
                    </li>
                    <li class="footer__nav-item">
                        <a class="footer__nav-link" href="<?= Yii::$app->urlManager->createUrl(['/public-offer']) ?>">
                            Публічна оферета
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <?= \app\widgets\ContactWidget::widget() ?>
    </div>

    <div class="footer__info container-fluid">
        <small class="footer__copy">
            <a class="footer__link" href="<?= Yii::$app->urlManager->createUrl(['/']) ?>">
                <?= Yii::$app->name?>
            </a> &copy; <?= date('Y') ?>
        </small>

        <div class="footer__partners">
            <?= Html::img('@web/img/icons/visa.svg', ['class' => 'footer__partners-img', 'alt' => 'VISA', 'width' => 32, 'height' => 32]) ?>

            <?= Html::img('@web/img/icons/mastercard.svg', ['class' => 'footer__partners-img', 'alt' => 'MasterCard', 'width' => 32, 'height' => 32]) ?>
        </div>

        <div class="footer__powered">
            <?= Yii::powered() ?>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
