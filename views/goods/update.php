<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Goods $model */

$this->title = 'Редагування товару: ' . $model->title;

$this->params['breadcrumbs'][] = [
    'label' => 'Товари',
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
<div class="goods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'category' => $category,
        'model' => $model,
        'subcategory' => $subcategory,
    ]) ?>

</div>
