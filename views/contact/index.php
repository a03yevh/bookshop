<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

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

$this->registerJsFile("@web/js/jquery.maskedinput.min.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$this->registerJs(
    '$("#feedbackform-phone").mask("+38 (099) 999 9999")'
);
?>
<section class="section container contact">
    <div class="contact__info">
        <?= $content->content ?>
        <div class="contact__list">
            <?php if (count($address) > 0): ?>
                <div class="contact__item">
                    <?php foreach($address as $item): ?>
                        <p class="contact__item-value"><?= $item->value ?></p>
                    <?php endforeach;?>
                </div>
            <?php endif;?>

            <?php if (count($time) > 0): ?>
                <div class="contact__item">
                    <?php foreach($time as $item): ?>
                        <p class="contact__item-value"><?= $item->value ?></p>
                    <?php endforeach;?>
                </div>
            <?php endif;?>

            <?php if (count($email) > 0): ?>
                <div class="contact__item">
                    <h4 class="contact__item-title">E-mail:</h4>
                    <?php foreach($email as $item): ?>
                        <p class="contact__item-value">
                            <a class="contact__item-link" href="mailto:<?= $item->value ?>"><?= $item->value ?></a>
                        </p>
                    <?php endforeach;?>
                </div>
            <?php endif;?>

            <?php if (count($phone) > 0): ?>
                <div class="contact__item">
                    <h4 class="contact__item-title">Телефон:</h4>
                    <?php foreach($phone as $item): ?>
                        <p class="contact__item-value">
                            <a class="contact__item-link" href="tel:<?= $item->value ?>"><?= $item->value ?></a>
                        </p>
                    <?php endforeach;?>
                </div>
            <?php endif;?>

            <?php if (count($social) > 0): ?>
                <hr>
                <h4>Соціальні мережі</h4>
                <ul class="social">
                    <?php foreach($social as $item): ?>
                        <?php if ($item->type == 'Viber'): ?>
                            <li class="social__item">
                                <a class="social__link" href="viber://chat?number=%2B<?= $item->value ?>">
                                    <?= Html::img('@web/img/icons/' . strtolower($item->type) . '.svg', ['class' => 'social_icon', 'alt' => $item->type, 'width' => 24, 'height' => 24, 'title' => $item->value]) ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="social__item">
                                <a class="social__link" href="<?= $item->value ?>">
                                    <?= Html::img('@web/img/icons/' . strtolower($item->type) . '.svg', ['class' => 'social_icon', 'alt' => $item->type, 'width' => 24, 'height' => 24, 'title' => $item->value]) ?>
                                </a>
                            </li>
                        <?php endif;?>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>
        </div>
    </div>

    <?php $form = ActiveForm::begin(
        [
            'id' => 'contact-form',
            'options' => [
                'class' => 'contact__form',
            ]
        ]
    ); ?>

    <h3 class="contact__description">Зворотній зв'язок</h3>

    <?= $form->field($feedback, 'name')->textInput(['placeholder' => $feedback->getAttributeLabel('name') . '*'])->label(false) ?>

    <?= $form->field($feedback, 'phone')->textInput(['placeholder' => $feedback->getAttributeLabel('phone') . '*'])->label(false) ?>

    <?= $form->field($feedback, 'message')->textarea(['rows' => 4, 'placeholder' => $feedback->getAttributeLabel('message') . '*'])->label(false) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Надіслати', ['class' => 'button', 'name' => 'contact-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</section>