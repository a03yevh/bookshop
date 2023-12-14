<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\GoodsImages $model */

$this->title = 'Редагування зображення';

$this->params['breadcrumbs'][] = [
    'label' => 'Товари',
    'url' => ['goods/index']
];
$this->params['breadcrumbs'][] = [
    'label' => 'Зображення',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->alt_text,
    'url' => ['view', 'id' => $model->id]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Редагування',
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="goods-images-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
