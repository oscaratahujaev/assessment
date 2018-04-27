<?php

use app\models\Category;
use app\models\CategoryParams;
use app\models\ParamType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryParams */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-params-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'param_type_id')->dropDownList(ArrayHelper::map(ParamType::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(['' => ''] + ArrayHelper::map(CategoryParams::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'formula')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
