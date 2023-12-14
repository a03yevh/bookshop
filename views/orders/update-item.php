<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */

$this->title = 'Редагування замовлення: #' . $model->order_id;

$this->params['breadcrumbs'][] = [
    'label' => 'Замовлення клієнтів',
    'url' => ['all']
];
$this->params['breadcrumbs'][] = [
    'label' => '#' . $model->order_id,
    'url' => ['view', 'id' => $model->order_id]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Редагування',
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-item', [
        'model' => $model,
    ]) ?>

</div>
