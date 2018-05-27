<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Years */

$this->title = Yii::t('app', 'Update Years: {nameAttribute}', [
    'nameAttribute' => $model->year,
]);
/*$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Years'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->year, 'url' => ['view', 'id' => $model->year]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Ўзгартириш');*/
?>
<div class="years-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
