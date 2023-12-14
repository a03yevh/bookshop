<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Goods $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJsFile("@web/js/jquery.maskedinput.min.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$this->registerJs(
    '$("#orderform-phone").mask("+38 (099) 999 9999")'
);
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="order-form__user-info">
        <div class="row">
            <h3>Замовник</h3>

            <div class="col-12 col-md-6">
                <?= $form->field($model, 'first_name')->textInput(['value' => Yii::$app->user->isGuest ? "" : Yii::$app->user->identity->first_name]) ?>
            </div>

            <div class="col-12 col-md-6">
                <?= $form->field($model, 'middle_name')->textInput(['value' => Yii::$app->user->isGuest ? "" : Yii::$app->user->identity->middle_name]) ?>
            </div>

            <div class="col-12 col-md-6">
                <?= $form->field($model, 'last_name')->textInput(['value' => Yii::$app->user->isGuest ? "" : Yii::$app->user->identity->last_name]) ?>
            </div>

            <div class="col-12 col-md-6">
                <?= $form->field($model, 'phone')->textInput(['value' => Yii::$app->user->isGuest ? "" : Yii::$app->user->identity->phone]) ?>
            </div>
        </div>
    </div>

    <div class="order-form__other__info">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Доставка</h3>

                <?= $form->field($model, 'delivery')->dropDownList(
                    [
                        'Самовивіз' => 'Самовивіз',
                        'Курʼєрська доставка' => 'Курʼєрська доставка',
                        'Нова пошта' => 'Нова пошта',
                        'Укрпошта' => 'Укрпошта',
                    ],
                    [
                        'prompt' => ''
                    ]
                ) ?>

                <?= $form->field($model, 'delivery_info')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-12 col-md-6">
                <h3>Спосіб оплати</h3>

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
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Надіслати', ['class' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
