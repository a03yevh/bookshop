<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Slider $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'page_url_key')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'imageFile', ['options' => ['class' => 'required']])->fileInput() ?>
        </div>

        <div class="col-12">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
