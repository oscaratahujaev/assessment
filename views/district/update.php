<?php

use app\models\Region;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\District */

$this->title = Yii::t('app', 'Update District: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Regions'), 'url' => ['/region/index']];
$this->params['breadcrumbs'][] = ['label' => Region::findOne($regionId)->name, 'url' => ['/region/view', 'id' => $regionId]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="district-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
