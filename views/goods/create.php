<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Goods $model */

$this->title = 'Додання товару';

$this->params['breadcrumbs'][] = [
    'label' => 'Товари',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'category' => $category,
        'model' => $model,
        'subcategory' => $subcategory,
    ]) ?>

</div>
