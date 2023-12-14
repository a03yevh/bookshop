<?php

use app\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\OrsersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::$app->controller->action->id === 'index' ? 'Замовлення' : 'Замовлення клієнтів';

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="control-btn">
        <?= Html::a('Фільтри', [''], ['class' => 'button button-filter']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <div class="form-filter d-none">
        <?= $this->render(
            '_search',
            [
                'action' => $action,
                'model' => $searchModel,
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
                    'attribute' => 'order_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return '<p style="text-align: center;"> #' . $data['order_id'] . '</p>';
                    },
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if($data['status'] === 'Нове') {
                            $status = '<span class="badge bg-success">Нове</span>';
                        } elseif ($data['status'] === 'Прийнято') {
                            $status = '<span class="badge bg-dark">Прийнято</span>';
                        } else {
                            $status = '<span class="badge bg-danger">Відхилено</span>';
                        }
                        return $status;
                    },
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($data) {
                        return date('d.m.Y H:i:s', $data['created_at']);
                    },
                ],

                [
                    'class' => ActionColumn::className(),
                    'template' => '{view} {link}',
                    'urlCreator' => function ($action, Orders $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->order_id]);
                     }
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>

</div>
