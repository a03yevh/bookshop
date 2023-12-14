<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GoodsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="goods-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-12 col-md-12">
            <?= $form->field($model, 'title') ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'articul') ?>
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
            <?= $form->field($model, 'genre')->textInput(['maxlength' => true]) ?>
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
            <?= $form->field($model, 'subcategory_id')->dropDownList(
                ArrayHelper::map($subcategory, 'id', 'title'),
                [
                    'prompt' => 'Оберіть підкатегорію...'
                ]
            ); ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'publisher') ?>
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
    </div>

    <div class="form-group">
        <?= Html::submitButton('Шукати', ['class' => 'button button--inverse']) ?>
        <?= Html::resetButton('Скинути', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
