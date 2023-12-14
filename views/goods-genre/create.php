<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\GoodsCharacteristics $model */

$this->title = 'Додання жанру';

$this->params['breadcrumbs'][] = [
    'label' => 'Товари',
    'url' => ['goods/index']
];
$this->params['breadcrumbs'][] = [
    'label' => $good->title,
    'url' => ['goods/view', 'id' => $good->id]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Жанр',
    'url' => ['index', 'id' => $good->id]
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="goods-genre-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
