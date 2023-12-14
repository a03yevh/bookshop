<?php

use app\models\GoodsImages;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Goods $model */

$this->title = $model->title;

$this->params['breadcrumbs'][] = [
    'label' => 'Товари',
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
\yii\web\YiiAsset::register($this);
?>
<div class="admin-section container goods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="control-btn">
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'button button--inverse']) ?>
        <?= Html::a('Жанр', ['/goods-genre/index', 'id' => $model->id], ['class' => 'button button--inverse']) ?>
        <?= Html::a('Зображення', ['/goods-images/index', 'id' => $model->id], ['class' => 'button button--inverse']) ?>
        <?= Html::a('Опис', ['/goods-description/index', 'id' => $model->id], ['class' => 'button button--inverse']) ?>
        <?= Html::a('Характеристики', ['/goods-characteristics/index', 'id' => $model->id], ['class' => 'button  button--inverse']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'button button--danger',
            'data' => [
                'confirm' => 'Ви впевнені, що хочете видалити цей елемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-12 col-xl-3">
            <?php
            if (GoodsImages::find()->where(['good_id' => $model->id])->count() === 0) {
                $image = Html::img('@web/img/goods/no-image.png', [
                    'style' => 'width:100%;max-width:512px',
                    'alt' => $model->title
                ]);
            } else {
                if (GoodsImages::findOne(['good_id' => $model->id, 'preview' => 'Так']) !== null) {
                    $image = GoodsImages::findOne(['good_id' => $model->id, 'preview' => 'Так'])->image;
                } else {
                    $image = GoodsImages::findOne(['good_id' => $model->id])->image;
                }

                $image =  Html::img('@web/img/goods/' . $image, [
                    'style' => 'width:100%;max-width:512px',
                    'alt' => $model->title
                ]);
            }

            echo $image;
            ?>
        </div>

        <div class="col-12 col-xl-9">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'title',
                    'author',
                    'articul',
                    'url_key',
                    'year',
                    'lang',
                    [
                        'attribute' => 'category_id',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $category = \app\models\Category::findOne(['id' => $data['category_id']])->title;
                            return $category;
                        },
                    ],
                    [
                        'attribute' => 'subcategory_id',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $subcategory = $data['subcategory_id'] === null ? '-' : $subcategory = \app\models\Subcategory::findOne(['id' => $data['subcategory_id']])->title;

                            return $subcategory;
                        },
                    ],
                    'publisher',
                    'genre',
                    'price',
                    'hide',
                    'available',
                    'keywords',
                    'description',
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
    </div>
</div>
