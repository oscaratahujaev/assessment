<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ParamType */

$this->title = Yii::t('app', 'Create Param Type');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Param Types'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="param-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
