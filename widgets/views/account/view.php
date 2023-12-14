<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

if (Yii::$app->user->isGuest) {
    $this->registerJsFile("@web/js/jquery.maskedinput.min.js",[
        'depends' => [
            \yii\web\JqueryAsset::className()
        ]
    ]);
    $this->registerJs(
        '$("#signupform-phone").mask("+38 (099) 999 9999")'
    );
}

?>

<div class="account-widget" id="account-widget">
    <header class="account-widget__header">
        <?php  if (Yii::$app->user->isGuest) : ?>
            <h2 class="account-widget__title">Увійти</h2>
        <?php else: ?>
            <header class="account-widget__user">
                <?= Html::img('@web/img/icons/user.svg', ['class' => 'account-widget__user-ava', 'alt' => 'Аватар користувача', 'width' => 45, 'height' => 45]) ?>

                <div class="account-widget__user-info">
                    <h4 class="account-widget__user-name">
                        <?= Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name ?>
                    </h4>
                    <p class="account-widget__user-email">
                        <?= Yii::$app->user->identity->email ?>
                    </p>
                </div>
            </header>
        <?php endif; ?>

        <?= Html::img('@web/img/icons/close.svg', ['class' => 'account-widget__close', 'id' => 'account-widget-close', 'alt' => 'Закрити', 'width' => 30, 'height' => 30]) ?>
    </header>

    <?php  if (Yii::$app->user->isGuest) : ?>
        <div class="login" id="login">
            <?php $form = ActiveForm::begin(
                [
                    'action' => ['/site/login'],
                    'enableAjaxValidation' => true,
                    'options' => [
                        'class' => 'login__form',
                        'id' => 'login-form',
                    ]
                ]
            ); ?>

            <?= $form->field($login, 'email')->textInput() ?>

            <?= $form->field($login, 'password')->passwordInput() ?>

            <div class="login__other">
                <?= $form->field($login, 'rememberMe')->checkbox() ?>

                <a class="login__link login__link--forgot">Забули пароль?</a>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Увійти', ['class' => 'button button--inverse', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <p class="login__info">Немає облікового запису? <a class="login__link login__link--sign-up">Зареєструватися</a>.</p>
        </div>

        <div class="sign-up d-none" id="sign-up">
            <?php $form = ActiveForm::begin(
                [
                    'action' => ['/site/sign-up'],
                    'enableAjaxValidation' => true,
                    'options' => [
                        'class' => 'login__form',
                        'id' => 'sign-up-form',
                    ]
                ]
            ); ?>

            <?= $form->field($sign_up, 'first_name')->textInput() ?>

            <?= $form->field($sign_up, 'last_name')->textInput() ?>

            <?= $form->field($sign_up, 'phone')->textInput() ?>

            <?= $form->field($sign_up, 'email')->textInput() ?>

            <?= $form->field($sign_up, 'password')->passwordInput() ?>

            <?= $form->field($sign_up, 'repeat')->passwordInput() ?>

            <div class="login__other">
                <?= $form->field($sign_up, 'term')->checkbox([
                    'template' => '<div class="form-check">{input}{label}{hint}</div>'
                ]) ?>

                <a class="login__link" href="<?= Yii::$app->urlManager->createUrl(['/public-offer/index']) ?>" target="_blank">Угода</a>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Зареєструватися', ['class' => 'button button--inverse', 'name' => 'sign-up-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <p class="login__info"><a class="login__link login__link--login">Увійти</a> | <a class="login__link login__link--forgot">Забули пароль?</a></p>
        </div>

        <div class="forgot d-none" id="forgot">
            <p class="forgot__desc">Будь ласка, вкажіть адресу електронної пошти, і ми надішлемо вам інструкції про те, як змінити пароль на новий.</p>
            <?php $form = ActiveForm::begin(
                [
                    'action' => ['/site/forgot-password'],
                    'enableAjaxValidation' => true,
                    'options' => [
                        'class' => 'login__form',
                        'id' => 'forgot-form',
                    ]
                ]
            ); ?>

            <?= $form->field($forgot_password, 'email')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Відновити', ['class' => 'button button--inverse', 'name' => 'forgot-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <p class="login__info"><a class="login__link login__link--login">Увійти</a> | <a class="login__link login__link--sign-up">Зареєструватись</a></p>
        </div>
    <?php else: ?>
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
    <?php endif; ?>
</div>
