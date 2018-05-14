<?php use app\models\Category;
use app\models\District;
use app\models\Quarter;
use app\models\Region;
use app\models\Years;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/*Values set for drop down lists for filters*/
$categories = Category::find()->all();
$regions = Region::find()->all();
$district = District::find()->all();
$quarter = Quarter::find()->all();
$year = Years::find()->all();
/*Values set for drop down lists for filters*/
?>


<?= Html::beginForm(Url::to([$url]), 'GET'); ?>
<div class="row">
    <div class="col-md-12">
        <?= Html::label('Категория', 'categoryId', ['class' => 'form-label']) ?>
        <?= Html::dropDownList('categoryId', $categoryId,
            ArrayHelper::map($categories, 'id', 'name'),
            ['class' => 'form-control', 'id' => 'category']); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-4">
        <?= Html::label('Вилоят', 'region', ['class' => 'form-label']) ?>
        <?= Html::dropDownList('regionId', $regionId,
            ArrayHelper::map($regions, 'id', 'name'),
            [
                'id' => 'region',
                'class' => 'form-control',
                'prompt' => ''
            ]
        ); ?>
    </div>
    <div class="col-md-3">
        <?= Html::label('Йил', 'region', ['class' => 'form-label']) ?>
        <?= Html::dropDownList('yearId', $yearId,
            ArrayHelper::map($year, 'year', 'year'),
            [
                'class' => 'form-control',
                'id' => 'year'
            ], [
                'required' => true
            ]
        ) ?>
    </div>
    <div class="col-md-3">
        <?= Html::label('Чорак', 'region', ['class' => 'form-label']) ?>
        <?= Html::dropDownList('quarterId', $quarterId,
            ArrayHelper::map($quarter, 'id', 'name'),
            [
                'id' => 'quarter',
                'class' => 'form-control'
            ]
        ); ?>
    </div>
    <div class="col-md-2">
        <?= Html::label(' ', 'region', ['class' => 'form-label']) ?>
        <?= Html::submitButton('Поиск', [
            'class' => 'btn btn-block btn-outline-primary',
            'id' => 'btn-submit',
        ]) ?>
    </div>
</div>
<?= Html::endForm() ?>

