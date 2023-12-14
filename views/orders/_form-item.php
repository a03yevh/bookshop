<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12 col-md-4">
            <?= $form->field($model, 'count')->textInput() ?>
        </div>

        <div class="col-12 col-md-4">
            <?= $form->field($model, 'good_price')->textInput() ?>
        </div>

        <div class="col-12 col-md-4">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
