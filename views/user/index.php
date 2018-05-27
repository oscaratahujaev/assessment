<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фойдаланувчилар';
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-md-12">

        <h2 class="text-center">Фойдаланувчилар
            <?= Html::a('<i class="fa fa-plus"></i>',
                ['/user/create'],
                [
                    'class' => 'btn btn-outline-primary float-right',
                    'title' => 'Фойдаланувчи яратиш',
                    'data-toggle' => 'tooltip'
                ]
            ) ?>
        </h2>
    </div>
    <div class="clearfix"></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //            'id',
            'username',
            //            'auth_key',
            //            'password_hash',
            //            'password_reset_token',
            //'email:email',
            //'status',
            //            'role',
            //'created_at',
            //'updated_at',
            //'address',
            //'tin',
            //'pin',
            //'region_id',
            //'district_id',
            //'phone_number',
            'fullname',
            [
                'label' => 'Роль',
                'value' => function ($model) {
                    return User::getRoleById($model->role);
                },
            ],
            //'birthdate',
            //'lastname',
            //'firstname',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a(
                            '<span class="fa fa-eye"></span> ',
                            $url,
                            [
                                'title' => 'view',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    //                    'update' => function ($url) {
                    //                        return Html::a(
                    //                            '<span class="fa fa-pencil-alt"></span> ',
                    //                            $url,
                    //                            [
                    //                                'title' => 'view',
                    //                                'data-pjax' => '0',
                    //                            ]
                    //                        );
                    //                    },
                ],
            ],
        ],
    ]); ?>
</div>
