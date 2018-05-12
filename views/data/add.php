<?php

/* @var $this yii\web\View */

use app\models\District;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$i = 3;
$this->title = 'About';
$districts = District::find()->where(['region_id' => $region_id])->all();
?>
<div class="site-about">

    <h3><?= Html::encode($category['name']) ?></h3>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            Туманлар
            <br>
            <?= Html::dropDownList('districtId', $districtId,
                ArrayHelper::map($districts, 'id', 'name'),
                [
                    'prompt' => 'Туманни танланг',
                    'class' => 'form-control',
                    'id' => 'category',
                    //                    'readonly' => true,
                ]); ?>
        </div>

        <div class="clearfix"></div>

        <div id="input-box">
            <div class="row col-md-12">

            <?php foreach ($data as $key => $item): ?>
                <div class="col-md-6">
                    <?= $item['param']['name'] ?><br>
                    <input type="text" id="data-value" class="form-control" name="<?= $key ?>"
                           aria-invalid="false">
                </div>


                <?php $i++; ?>
            <?php endforeach; ?>
            </div>

        </div>


    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Саклаш'), ['class' => 'btn btn-primary btn-save']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

