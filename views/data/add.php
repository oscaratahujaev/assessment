<?php

/* @var $this yii\web\View */

use app\models\District;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$i = 3;
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
$districts = District::find()->where(['region_id' => $region_id])->all();
?>
<div class="site-about">


    <h1><?= Html::encode($category['name']) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    <?= Html::dropDownList('districtId', 1,
        ArrayHelper::map($districts, 'id', 'name'),
        ['prompt' => 'Select District', 'class' => 'form-control', 'id' => 'category']); ?>
    <?php foreach ($data as $item): ?>
        <p>
            <?= $item['param']['name'] ?><br>
            <input type="text" id="data-value" class="form-control" name="<?= $i ?>" aria-invalid="false">
        </p>
        <?php $i++; ?>
    <?php endforeach; ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
