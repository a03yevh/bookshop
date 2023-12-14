<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GoodsCharacteristics $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="goods-characteristics-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'parameter')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12">
            <?= $form->field($model, 'value')->widget(CKEditor::className(), [
                'editorOptions' => [
                    'language' => 'uk',
                    'preset' => 'characteristics',
                    'inline' => false,
                ],
            ]); ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
