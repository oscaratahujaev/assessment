<?php

use app\models\Category;
use app\models\Ministry;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryMinistery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-ministery-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ministery_id')
        ->dropDownList(ArrayHelper::map(Ministry::find()->all(), 'id', 'name'), [
            'prompt' => 'Вазирликни танланг'
        ]) ?>

    <?= $form->field($model, 'category_id')
        ->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name'), [
            'prompt' => 'Категорияни танланг'
        ]); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
