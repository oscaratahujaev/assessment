<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoryDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Datas');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Data'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'region_id',
                'value' => function ($data) {
                    return $data->region ? $data->region->name : "";
                }
            ],
            [
                'attribute' => 'district_id',
                'value' => function ($data) {
                    return $data->district ? $data->district->name : "";
                }
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($data) {
                    return $data->category ? $data->category->name : "";
                }
            ],
            [
                'attribute' => 'param_id',
                'value' => function ($data) {
                    return $data->param ? $data->param->name : "";
                }
            ],

            'value',
            //'creator',
            //'created_at',
            //'modifier',
            //'modified_at',
            //'quarter',

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
                    'update' => function ($url) {
                        return Html::a(
                            '<span class="fa fa-pencil-alt"></span> ',
                            $url,
                            [
                                'title' => 'view',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    'delete' => function ($url) {
                        return Html::a(
                            '<span class="fa fa-trash"></span> ',
                            $url,
                            [
                                'title' => 'Delete',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
