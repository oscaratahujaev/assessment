<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CategoryParams */

$this->title = Yii::t('app', 'Create Category Params');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category Params'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-params-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
