<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Профіль';

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
\yii\web\YiiAsset::register($this);
?>
<div class="user-profile">

    <h1><?= Html::encode($this->title) ?> <?= Yii::$app->user->can('manager') ? 'менеджера': '' ?></h1>

    <div class="user-profile__info">
        <div class="user-profile__item">
            <h3 class="user-profile__title">Імʼя</h3>
            <p class="user-profile__value"><?= $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name ?></p>
        </div>

        <div class="user-profile__item">
            <h3 class="user-profile__title">E-mail</h3>
            <p class="user-profile__value"><?= $model->email ?></p>
        </div>

        <div class="user-profile__item">
            <h3 class="user-profile__title">Телефон</h3>
            <p class="user-profile__value"><?= $model->phone ?></p>
        </div>

        <div class="user-profile__item">
            <h3 class="user-profile__title">Веб-сайт</h3>
            <p class="user-profile__value"><?= $model->website === null ? 'не задано' : $model->website ?></p>
        </div>

        <div class="user-profile__item">
            <h3 class="user-profile__title">Компанія</h3>
            <p class="user-profile__value"><?= $model->company === null ? 'не задано' : $model->company ?></p>
        </div>

        <div class="user-profile__item">
            <h3 class="user-profile__title">Коментарі</h3>
            <p class="user-profile__value"><?= $model->comment === null ? 'не задано' : $model->comment ?></p>
        </div>
    </div>

    <p class="control-btn">
        <?= Html::a('Редагувати', ['update-profile'], ['class' => 'button button--inverse']) ?>

        <?php
        Modal::begin([
            'title' => 'Редагування паролю',
            'toggleButton' => [
                'label' => 'Змінити пароль',
                'tag' => 'a',
                'class' => 'button button--inverse',
            ],
            'size' => 'modal-md'
        ]);
        ?>

        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($password, 'password')->passwordInput() ?>

        <?= $form->field($password, 'repeat')->passwordInput() ?>

        <?= Html::submitButton('Зберегти', ['class' => 'button mt-3']) ?>

        <?php ActiveForm::end() ?>

        <?php Modal::end(); ?>
    </p>
</div>