<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Менеджери';

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
?>
<div class="user-managers">

    <h2><?= Html::encode($this->title) ?></h2>

    <p class="control-btn">
        <?= Html::a('Фільтри', [''], ['class' => 'button']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <div class="form-filter d-none">
        <?= $this->render(
            '_search',
            [
                'action' => ['managers'],
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
                        $last_name = $data['last_name'];
                        $first_name = ' ' . $data['first_name'];
                        $middle_name = ' ' . $data['middle_name'];
                        return $last_name . $first_name . $middle_name
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