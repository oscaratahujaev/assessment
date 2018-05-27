<?php use app\models\Category;
use app\models\District;
use app\models\Quarter;
use app\models\Region;
use app\models\Years;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/*Values set for drop down lists for filters*/
$categories = Category::find()->all();
$regions = Region::find()->all();
$district = District::find()->all();
$quarter = Quarter::find()->all();
$year = Years::find()->all();
/*Values set for drop down lists for filters*/
$form = ActiveForm::begin(['method' => 'GET', 'action' => Url::to(['/score/values'])]); ?>
<div class="row">
    <div class="col-md-4">
        <?= Html::label('Вилоят', 'region', ['class' => 'form-label']) ?>
        <?= Html::dropDownList('regionID', $regionId,
            ArrayHelper::map($regions, 'id', 'name'),
            [
                'id' => 'region',
                'class' => 'form-control'
            ]
        ); ?>
    </div>
    <div class="col-md-3">
        <?= Html::label('Йил', 'region', ['class' => 'form-label']) ?>
        <?= Html::dropDownList('yearID', $yearId,
            ArrayHelper::map($year, 'year', 'year'),
            [
                'class' => 'form-control',
                'id' => 'year'
            ]
        ) ?>
    </div>
    <div class="col-md-3">
        <?= Html::label('Чорак', 'region', ['class' => 'form-label']) ?>
        <?= Html::dropDownList('quarterID', $quarterId,
            ArrayHelper::map($quarter, 'id', 'name'),
            [
                'id' => 'quarter',
                'class' => 'form-control'
            ]
        ); ?>
    </div>
    <div class="col-md-2">
        <?= Html::label(' ', 'region', ['class' => 'form-label']) ?>
        <button class="btn btn-block btn-outline-primary" id="btn-submit" type="submit">Излаш</button>
    </div>
</div>

<?php ActiveForm::end()?>

