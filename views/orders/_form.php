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
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'status')->dropDownList(
                [
                    'Нове' => 'Нове',
                    'Прийнято' => 'Прийнято',
                    'Відхилено' => 'Відхилено',
                ]
            ) ?>
        </div>

        <div class="col-12 col-md-6">
            <?= $form->field($model, 'payment')->dropDownList(
                [
                    'Безготівкова оплата' => 'Безготівкова оплата',
                    'Оплата готівкою' => 'Оплата готівкою',
                ],
                [
                    'prompt' => ''
                ]
            ) ?>
        </div>

        <div class="col-12">
            <?= $form->field($model, 'user_info')->widget(CKEditor::className(), [
                'editorOptions' => [
                    'language' => 'uk',
                    'preset' => 'characteristics',
                    'inline' => false,
                ],
            ]); ?>
        </div>

        <div class="col-12">
            <?= $form->field($model, 'delivery')->textInput() ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
