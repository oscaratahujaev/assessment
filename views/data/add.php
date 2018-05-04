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
        <div class="col-md-4">
            Туманлар
            <br>
            <?= Html::dropDownList('districtId', $districtId,
                ArrayHelper::map($districts, 'id', 'name'),
                ['prompt' => 'Туманни танланг', 'class' => 'form-control', 'id' => 'category']); ?>
        </div>
        <?php foreach ($data as $key => $item): ?>
            <div class="col-md-4">
                <?= $item['param']['name'] ?><br>
                <input type="text" id="data-value" class="form-control" name="<?= $key ?>" aria-invalid="false">
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Саклаш'), ['class' => 'btn btn-primary btn-save']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

