<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */

$this->title = '#' . $model->order_id;

$this->params['breadcrumbs'][] = [
    'label' => Yii::$app->user->can('manager') ? 'Замовлення клієнтів' : 'Замовлення',
    'url' => Yii::$app->user->can('manager') ? ['all'] : ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('manager')): ?>
        <p class="control-btn">
            <?= Html::a('Редагувати', ['update', 'id' => $model->order_id], ['class' => 'button button--inverse']) ?>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'user_info:raw',
            [
                'attribute' => 'price',
                'label' => 'Сума замовлення',
                'format' => 'raw',
                'value' => function ($data) {

                    return number_format(\app\models\Orders::find()->where(['order_id' => $data->order_id])->sum('price'), 2, '.', ' ') . ' ₴';
                },
            ],
            'payment',
            'delivery',
            'status',
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

    <hr>

    <h2>Товари</h2>

    <?php Pjax::begin(); ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'good_id',
                    'label' => 'Товар',
                    'format' => 'raw',
                    'value' => function ($data) {
                        $good = \app\models\Goods::findOne(['id' => $data['good_id']]);
                        $category = \app\models\Category::findOne(['id' => $good->category_id])->title;
                        $subcategory = $good->subcategory_id === null ? '-' : $subcategory = \app\models\Subcategory::findOne(['id' => $good->subcategory_id])->title;

                        $hide = $good->hide === 'Ні' ? '' : '<span class="badge bg-secondary">Недоступно</span><br>';
                        $hide = $good->available === 'Так' ? $hide : '<span class="badge bg-secondary">Немає в наявності</span><br>';

                        return $hide . $good->title .
                            '<br><b>Артикул:</b> ' . $good->articul . '</small>
                             <br><small><b>Категорія:</b> ' . $category . '</small>
                             <br><small><b>Підкатегорія:</b> ' . $subcategory . '</small>';
                    },
                ],
                [
                    'attribute' => 'good_id',
                    'label' => 'Зображення',
                    'format' => 'raw',
                    'value' => function ($data) {

                        $good = \app\models\Goods::findOne(['id' => $data['good_id']]);
                        if (\app\models\GoodsImages::find()->where(['good_id' => $good->id])->count() === 0) {
                            $image = Html::img('@web/img/goods/no-image.png', [
                                'style' => 'width:100px;',
                                'alt' => $good->title
                            ]);
                        } else {
                            if (\app\models\GoodsImages::findOne(['good_id' => $good->id, 'preview' => 'Так']) !== null) {
                                $image = \app\models\GoodsImages::findOne(['good_id' => $good->id, 'preview' => 'Так'])->image;
                            } else {
                                $image = \app\models\GoodsImages::findOne(['good_id' => $good->id])->image;
                            }

                            $image = Html::img('@web/img/goods/' . $image, [
                                'style' => 'width:100px;',
                                'alt' => $good->title
                            ]);
                        }

                        return $image;
                    },
                ],
                'count',
                [
                    'attribute' => 'good_price',
                    'label' => '₴ / шт.',
                    'value' => function ($data) {
                        return number_format($data['good_price'], 2, '.', ' ');
                    },
                ],
                [
                    'attribute' => 'price',
                    'label' => '₴',
                    'value' => function ($data) {
                        return number_format($data['price'], 2, '.', ' ');
                    },
                ],

                [
                    'class' => ActionColumn::className(),
                    'template' => Yii::$app->user->can('manager') ? '{view} {update} {delete} {link}' : '{view} {link}',
                    'urlCreator' => function ($action, $model, $key, $index, $column) {
                        return Url::toRoute([$action . '-item', 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>

    <hr>

    <h3 class="d-flex justify-content-between">
        Cума:
        <span>
            <?=number_format(\app\models\Orders::find()->where(['order_id' => $model->order_id])->sum('price'), 2, '.', ' ') ?> ₴
        </span>
    </h3>
</div>
