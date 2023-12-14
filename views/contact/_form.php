<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Contact $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-12 col-md-6 col-xl-4">
            <?= $form->field($model, 'type')->dropDownList([
                    'Адреса' => 'Адреса',
                    'Електронна адреса' => 'Електронна адреса',
                    'Телефон' => 'Телефон',
                    'Час роботи' => 'Час роботи',
                    'Instagram' => 'Instagram',
                    'Telegram' => 'Telegram',
                    'Viber' => 'Viber',
                ],
                [
                    'prompt' => ''
                ])
            ?>
        </div>
        <div class="col-12 col-md-6 col-xl-8">
            <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
