<?php

use app\models\Category;
use app\models\District;
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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label("Категория номи") ?>

    <?= $form->field($model, 'ministry_id')
        ->dropDownList(ArrayHelper::map(Ministry::find()->all(), 'id', 'name'))->label("Вазирлик номи"); ?>
    <?= $form->field($model, 'place_type')->dropDownList(['' => ''] + District::$placeType); ?>
    <?= $form->field($model, 'factor_column')->input('number'); ?>

    <?= $form->field($model, 'score_class')->dropDownList(Category::getScoreClasses()); ?>


    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
