<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Slider $model */

$this->title = 'Редагування слайду: ' . $model->title;

$this->params['breadcrumbs'][] = [
    'label' => 'Слайдер',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->title,
    'url' => ['view', 'id' => $model->id]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Редагування',
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="slider-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'subcategory' => $subcategory,
    ]) ?>

</div>
