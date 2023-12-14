<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Товари';

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="control-btn">
        <?= Html::a('Додати', ['create'], ['class' => 'button button--inverse']) ?>
        <?= Html::a('Фільтри', [''], ['class' => 'button button-filter']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <div class="form-filter d-none">
        <?= $this->render(
            '_search',
            [
                'action' => ['index'],
                'category' => $category,
                'model' => $searchModel,
                'subcategory' => $subcategory,
            ]
        )
        ?>
    </div>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'title',
                'label' => 'Товар',
                'format' => 'raw',
                'value' => function ($data) {
                    $category = \app\models\Category::findOne(['id' => $data['category_id']])->title;
                    $subcategory = $data['subcategory_id'] === null ? '-' : $subcategory = \app\models\Subcategory::findOne(['id' => $data['subcategory_id']])->title;
                    $author = $data['author'] === null ? '-' : $publisher = $data['author'];

                    $hide = $data['hide'] === 'Ні' ? '' : '<span class="badge bg-danger">Приховано</span><br>';
                    return $hide . $data['title'] .
                           '<br><small><b>Категорія:</b> ' . $category . '</small>
                            <br><small><b>Підкатегорія:</b> ' . $subcategory . '</small>
                            <br><small><b>Автор:</b> ' . $author . '</small>';
                },
            ],
            [
                'attribute' => 'articul',
                'format' => 'raw',
                'value' => function ($data) {
                    if (\app\models\GoodsImages::find()->where(['good_id' => $data['id']])->count() === 0) {
                        $image = Html::img('@web/img/goods/no-image.png', [
                            'style' => 'width:150px;',
                            'alt' => $data['title']
                        ]);
                    } else {
                        if (\app\models\GoodsImages::findOne(['good_id' => $data['id'], 'preview' => 'Так']) !== null) {
                            $image = \app\models\GoodsImages::findOne(['good_id' => $data['id'], 'preview' => 'Так'])->image;
                        } else {
                            $image = \app\models\GoodsImages::findOne(['good_id' => $data['id']])->image;
                        }

                        $image = Html::img('@web/img/goods/' . $image, [
                            'style' => 'width:150px;',
                            'alt' => $data['title']
                        ]);
                    }

                    return $image . '<br><small><b>' . $data['articul'] . '</b></small>';
                },
            ],
            [
                'attribute' => 'price',
                'label' => 'Ціна, грн',
                'value' => function ($data) {
                    return number_format($data['price'], 2, '.', '');
                },
            ],
            'available',
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
