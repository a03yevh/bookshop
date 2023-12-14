<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Користувачі';

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="control-btn">
        <?= Html::a('Фільтри', [''], ['class' => 'button button-filter', 'type' => 'button']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <div class="form-filter d-none">
        <?= $this->render(
            '_search',
            [
                'action' => ['index'],
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
                    'attribute' => 'last_name',
                    'label' => 'Користувач',
                    'format' => 'raw',
                    'value' => function ($data) {
                        $role = \app\models\AuthAssignment::findOne(['user_id' => $data['id']])->item_name;
                        $role = $role == 'manager' ? 'Менеджер' : 'Клієнт';

                        $last_name = $data['last_name'];
                        $first_name = ' ' . $data['first_name'];
                        $middle_name = ' ' . $data['middle_name'];
                        return '<span class="badge bg-dark">' . $role . '</span>'
                            . '<br>' . $last_name . $first_name . $middle_name
                            . '<br><b>E-mail</b>: <a href="mailto:' . $data['email'] . '">' . $data['email'] . '</a>';
                    },
                ],

                [
                    'class' => ActionColumn::className(),
                    'template' => '{view} {update} {link}',
                    'urlCreator' => function ($action, $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>

</div>