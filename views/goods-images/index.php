<?php

use app\models\GoodsImages;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Зображення товару';

$this->params['breadcrumbs'][] = [
    'label' => 'Товари',
    'url' => ['goods/index']
];
$this->params['breadcrumbs'][] = [
    'label' => $good->title,
    'url' => ['goods/view', 'id' => $good->id]
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="goods-images-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="control-btn">
        <?= Html::a('Додати', ['create', 'id' => $good->id], ['class' => 'button button--inverse']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'alt_text',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::img('@web/img/goods/' . $data['image'], [
                        'style' => 'width:150px;',
                        'alt' => $data['alt_text']
                    ]);
                },
            ],
            'preview',
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return date('d.m.Y H:i:s', $data['created_at']);
                },
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {link}',
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
    </div>
    <?php Pjax::end(); ?>

</div>
