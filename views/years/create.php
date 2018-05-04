<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Years */

$this->title = Yii::t('app', 'Create Years');
?>
<div class="years-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
