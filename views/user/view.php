<?php

use app\components\Functions;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->fullname;
?>
<div class="user-view">

    <h3><?= Html::encode($this->title) ?>
        <?= Html::a('<i class="fa fa-pencil-alt"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary float-right']) ?>
    </h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            [
                'label' => 'Статус',
                'value' => $model->status == 1 ? 'Inactive' : 'Active',
            ],
            [
                'label' => 'Роль',
                'value' => Functions::getUserRole($model->role),
            ],
            [
                'label' => 'Ташкилот',
                'value' => $model->ministry ? $model->ministry->name : "",
            ],
            'phone_number',
            'email',
        ],
    ]) ?>

</div>
