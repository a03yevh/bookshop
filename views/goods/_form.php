<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Goods $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12 col-xl-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'articul')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'url_key')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'category_id')->dropDownList(
                ArrayHelper::map($category, 'id', 'title'),
                [
                    'prompt' => 'Оберіть категорію...'
                ]
            ); ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?php
            if ($subcategory === null) {
                echo $form->field($model, 'subcategory_id')->dropDownList(
                    [
                        'prompt' => 'Оберіть підкатегорію...'
                    ],
                    [
                        'disabled' => 'disabled'
                    ]
                );
            } else {
                echo $form->field($model, 'subcategory_id')->dropDownList(
                    ArrayHelper::map($subcategory, 'id', 'title'),
                    [
                        'prompt' => 'Оберіть підкатегорію...'
                    ]
                );
            }
            ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'publisher')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'hide')->dropDownList(
                [
                    'Так' => 'Так',
                    'Ні' => 'Ні',
                ],
                [
                    'prompt' => ''
                ]
            ) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'available')->dropDownList(
                [
                    'Так' => 'Так',
                    'Ні' => 'Ні',
                ],
                [
                    'prompt' => ''
                ]
            ) ?>
        </div>

        <div class="col-12">
            <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
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
