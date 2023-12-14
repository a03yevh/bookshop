<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Slider $model */

$this->title = 'Додання слайдів';

$this->params['breadcrumbs'][] = [
    'label' => 'Слайдер',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="slider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'subcategory' => $subcategory,
    ]) ?>

</div>
