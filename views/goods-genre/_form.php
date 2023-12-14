<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GoodsCharacteristics $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="goods-genre-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
