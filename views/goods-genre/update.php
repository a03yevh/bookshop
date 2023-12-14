<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\GoodsCharacteristics $model */

$this->title = 'Редагування жанру: ' . $model->value;

$this->params['breadcrumbs'][] = [
    'label' => 'Товари',
    'url' => ['goods/index']
];
$this->params['breadcrumbs'][] = [
    'label' => $good->title,
    'url' => ['good/view', 'id' => $good->id]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Жанр',
    'url' => ['index', 'id' => $good->id]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->value,
    'url' => ['view', 'id' => $model->id]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Редагування',
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="goods-genre-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
