<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Categories';
?>
<div class="category-index">
    <h2>Мезон-индикаторлари</h2>
    <p>
        <?= Html::a('Янги қўшиш <i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'place_type',
                'value' => function ($data) {
                    return \app\models\District::getPlaceTypeById($data->place_type);

                }
            ],
            [
                'attribute' => 'score_class',
                'value' => function ($data) {
                    return \app\models\Category::getScoreClassById($data->score_class);

                }
            ],
            'factor_column',

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:70px;'],
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
                    //                    'delete' => function ($url) {
                    //                        return Html::a(
                    //                            '<span class="fa fa-trash"></span> ',
                    //                            $url,
                    //                            [
                    //                                'title' => 'Delete',
                    //                                'data-pjax' => '0',
                    //                            ]
                    //                        );
                    //                    },
                ],
            ],
        ],
    ]); ?>
</div>
