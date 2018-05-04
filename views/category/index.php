<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
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
            ],
        ],
    ]); ?>
</div>
