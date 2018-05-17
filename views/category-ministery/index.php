<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoryMinisterySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Category Ministeries';
?>
<div class="category-ministery-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category Ministery', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ministery_id',
            'category_id',
            'creator',
            'created_date',
            //'modiefier',
            //'modiefied_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
