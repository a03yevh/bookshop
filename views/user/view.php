<?php

use app\models\AuthAssignment;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->last_name . ' ' . mb_substr($model->first_name, 0, 1) . '.';

$this->params['breadcrumbs'][] = [
    'label' => $role == 'manager' ? 'Менеджері' : 'Користувачі',
    'url' => $role == 'manager' ? ['managers'] : ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => $_SERVER['REQUEST_URI']
];
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p class="control-btn">
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'button button--inverse']) ?>
        <?= Html::a($role === 'client' ? 'Зробити менеджером' : 'Видалити менеджера', ['change-role', 'id' => $model->id], [
            'class' => 'button button--inverse',
            'data' => [
                'confirm' => $model->status === 10 ? 'Ви впевнені, що хочете назначити менеджера?' : 'Ви впевнені, що хочете видалити менеджера?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a($model->status === 10 ? 'Заблокувати' : 'Розблокувати', ['ban', 'id' => $model->id], [
            'class' => 'button button--inverse',
            'data' => [
                'confirm' => $model->status === 10 ? 'Ви впевнені, що хочете заблокувати користувача?' : 'Ви впевнені, що хочете розблокувати користувача?',
                'method' => 'post',
            ],
        ]) ?>
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
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($data) {
                    $status_class = $data['status'] == 10 ? 'success' : 'danger';
                    $status_text = $data['status'] == 10 ? 'Активний' : 'Заблоковано';

                    return '<span class="badge bg-' . $status_class . '">' . $status_text . '</span>';
                },
            ],
            [
                'attribute' => 'id',
                'attribute' => 'Роль',
                'format' => 'raw',
                'value' => function ($data) {
                    $role = AuthAssignment::findOne(['user_id' => $data['id']])->item_name;
                    $role = $role == 'manager' ? 'Менеджер' : 'Клієнт';
                    return '<span class="badge bg-dark">' . $role . '</span>';
                },
            ],
            'last_name',
            'first_name',
            'middle_name',
            'email:email',
            'phone',
            'website:url',
            'company',
            'comment',
        ],
    ]) ?>

</div>