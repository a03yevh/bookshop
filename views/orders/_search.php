<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\OrsersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['all'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'order_id') ?>
        </div>

        <div class="col-12 col-md-6">
            <?= $form->field($model, 'status')->dropDownList(
                [
                    'Нове' => 'Нове',
                    'Прийнято' => 'Прийнято',
                    'Відхилено' => 'Відхилено',
                ],
                [
                    'prompt' => '',
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
