<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Опис';

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
<div class="goods-description-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="control-btn">
        <?php if ($model === null): ?>
            <?= Html::a('Додати', ['create', 'id' => $good->id], ['class' => 'button button--inverse']) ?>
        <?php else: ?>
            <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'button button--inverse']) ?>
            <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
                'class' => 'button button--danger',
                'data' => [
                    'confirm' => 'Ви впевнені, що хочете видалити цей елемент?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif;?>
    </p>

    <?php if ($model === null): ?>
        <div class="alert alert-info" role="alert">
            Опис товару відсутній.
        </div>
    <?php else: ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'text:raw',
            ],
        ]) ?>
    <?php endif;?>

</div>
