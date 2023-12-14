<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\GoodsDescription $model */

$this->title = 'Додання опису товару';

$this->params['breadcrumbs'][] = [
    'label' => 'Товари',
    'url' => ['goods/index']
];
$this->params['breadcrumbs'][] = [
    'label' => $good->title,
    'url' => ['goods/view', 'id' => $good->id]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Опис',
    'url' => ['index', 'id' => $good->id]
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="goods-description-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
