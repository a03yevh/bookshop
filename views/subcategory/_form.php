<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Subcategory $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="subcategory-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12 col-md-6 col-xl-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'url_key')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
