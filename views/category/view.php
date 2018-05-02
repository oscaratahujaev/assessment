<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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

    <div class="row">
        <div class="col-md-12">
            <?= Html::a('Add param', ['/category-params/create', 'categoryId' => $model->id], ['class' => 'btn btn-success']) ?>
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
                        'headerOptions'=>['style'=>'width:70px;'],
                        'controller' => 'category-params',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['/category-params/update', 'id' => $model->id, 'categoryId' => $model->category_id]);
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>

    </div>


</div>
