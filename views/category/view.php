<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->name;
?>
<div class="category-view">

    <h3 class="text-center"><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Ўзгартириш', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <div class="row">

        <div class="col-md-12" style="margin-bottom:30px;">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'factor_column',
                    [
                        'label' => 'score_class',
                        'value' => \app\models\Category::getScoreClassById($model->score_class),
                    ],
                ],
            ]) ?>
        </div>


        <div class="col-md-12">
            <h2 class="text-center">Масъул ташкилотлар
                <?= Html::a('<i class="fa fa-plus"></i>',
                    ['/category/add-ministry', 'categoryId' => $model->id],
                    [
                        'class' => 'btn btn-outline-primary float-right',
                        'title' => 'Ташкилот қўшиш',
                        'data-toggle' => 'tooltip'
                    ]
                ) ?>
            </h2>

            <?= GridView::widget([
                'dataProvider' => $minstryDataProvider,
                'filterModel' => $ministrySearchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'ministery_id',
                        'value' => function ($data) {
                            return $data->ministery ? $data->ministery->name : "";

                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['style' => 'width:70px;'],
                        'controller' => 'category-ministery',
                        'buttons' => [
                            'delete' => function ($url) {
                                return Html::a(
                                    '<span class="fa fa-trash"></span> ',
                                    $url,

                                    [
                                        'title' => 'Delete',
                                        'data' => [
                                            'confirm' => Yii::t('main', 'Ушбу ташкилотни ўчирмоқчимисиз?'),
                                            'method' => 'post',
                                        ],
                                    ]
                                );
                            },
                        ],
                    ],
                ],
            ]); ?>

        </div>

        <div class="clearfix"></div>
        <div class="col-md-12" style="margin-top: 30px">
            <h2 class="text-center">Индикатор параметрлари
                <?= Html::a('<i class="fa fa-plus"></i>',
                    ['/category-params/create', 'categoryId' => $model->id],
                    [
                        'class' => 'btn btn-outline-primary float-right',
                        'title' => 'Ташкилот қўшиш',
                        'data-toggle' => 'tooltip',
                    ]
                ) ?>
            </h2>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    [
                        'attribute' => 'param_type_id',
                        'value' => function ($data) {
                            return $data->paramType ? $data->paramType->name : "";

                        }
                    ],
                    [
                        'attribute' => 'parent_id',
                        'value' => function ($data) {
                            return $data->parent ? $data->parent->name : "";

                        }
                    ],
                    'formula',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['style' => 'width:70px;'],
                        'controller' => 'category-params',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<span class="fa fa-pencil-alt"></span>', ['/category-params/update', 'id' => $model->id, 'categoryId' => $model->category_id]);
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>

    </div>


</div>
