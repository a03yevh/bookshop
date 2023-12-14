<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-search mb-5">

    <?php $form = ActiveForm::begin([
        'action' => $action,
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'first_name') ?>
        </div>
        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'last_name') ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'email') ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'phone') ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'website') ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'company') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Шукати', ['class' => 'button button--inverse']) ?>
        <?= Html::resetButton('Скинути', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>