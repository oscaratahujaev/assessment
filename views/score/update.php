<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Score */

$this->title = Yii::t('app', 'Update Score: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Scores'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = Yii::t('app', 'Ўзгартириш');
?>
<div class="score-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
