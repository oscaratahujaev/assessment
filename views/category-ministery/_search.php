<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryMinisterySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-ministery-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ministery_id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'creator') ?>

    <?= $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'modiefier') ?>

    <?php // echo $form->field($model, 'modiefied_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
