<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GoodsImages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="goods-images-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'alt_text')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'preview')->dropDownList(
                [
                    'Так' => 'Так',
                    'Ні' => 'Ні',
                ],
                [
                    'prompt' => ''
                ]
            ) ?>
        </div>

        <div class="col-12 col-xl-4">
            <?= $form->field($model, 'imageFile', ['options' => ['class' => 'required']])->fileInput() ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
