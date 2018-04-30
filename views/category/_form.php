<?php

use app\models\Ministry;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ministry_id')->dropDownList(ArrayHelper::map(Ministry::find()->all(), 'id', 'name')); ?>
    <?= $form->field($model, 'place_type')->dropDownList(['1' => 'Шахар', '2' => 'Кишлок']); ?>
    <?= $form->field($model, 'factor_column')->input('number'); ?>
    <?= $form->field($model, 'score_class')->dropDownList(['1' => 'DefaultScore', '2' => 'EnterpriseScore']); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>