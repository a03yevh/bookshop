<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Slider $model */

$this->title = $model->title;

$this->params['breadcrumbs'][] = [
    'label' => 'Слайдер',
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
\yii\web\YiiAsset::register($this);
?>
<div class="slider-view">

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
            'title',
            'description',
            'page_url_key',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::img('@web/img/slider/' . $data['image'], [
                        'style' => 'width:300px;',
                        'alt' => $data['title']
                    ]);;
                },
            ],
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
