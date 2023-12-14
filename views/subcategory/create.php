<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Subcategory $model */

$this->title = 'Додання підкатегорії';

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
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="subcategory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
