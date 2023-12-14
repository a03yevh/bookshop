<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Subcategory $model */

$this->title = 'Редагування підкатегорії: ' . $model->title;

$this->params['breadcrumbs'][] = [
    'label' => 'Категорії',
    'url' => ['category/index']
];
$this->params['breadcrumbs'][] = [
    'label' => $category->title,
    'url' => ['category/view', 'id' => $category->id]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Підкатегорії',
    'url' => ['index', 'id' => $category->id]
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
<div class="subcategory-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
