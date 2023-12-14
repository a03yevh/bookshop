<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Content $model */

$this->title = $model->title;

$this->params['breadcrumbs'][] = [
    'label' => 'Контент',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
\yii\web\YiiAsset::register($this);
?>
<div class="content-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="control-btn">
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'button button--inverse']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function ($data) {
                    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
                    $host = $_SERVER['HTTP_HOST'];

                    return Html::a($protocol . $host . $data['url'], [$protocol . $host . $data['url']]);
                },
            ],
            'keywords',
            'description',
            'content:raw',
            [
                'attribute' => 'updated_at',
                'value' => function ($data) {
                    return date('d.m.Y H:i:s', $data['updated_at']);
                },
            ],
        ],
    ]) ?>

</div>
