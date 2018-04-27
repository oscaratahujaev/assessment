<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ministry */

$this->title = Yii::t('app', 'Create Ministry');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ministries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ministry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
