<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\GoodsCharacteristics $model */

$this->title = $model->value;

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
    'url' => ['index', 'id' => $good->id],
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
\yii\web\YiiAsset::register($this);
?>
<div class="admin-section container goods-genre-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="control-btn">
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'button button--inverse']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'button button--danger',
            'data' => [
                'confirm' => 'Ви впевнені, що хочете видалити цей елемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'value',
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return date('d.m.Y H:i:s', $data['created_at']);
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($data) {
                    return date('d.m.Y H:i:s', $data['updated_at']);
                },
            ],
        ],
    ]) ?>

</div>
