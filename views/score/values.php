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

<?= Html::beginForm(Url::to(['/score/values']), 'GET'); ?>
<div class="row score-filter">
    <div class="col-md-4">
        <?= Html::label('Вилоят', 'region', ['class' => 'form-label']) ?>
        <?= Html::dropDownList('regionId', $regionId,
            ArrayHelper::map($regions, 'id', 'name'),
            [
                'id' => 'region',
                'class' => 'form-control',
                'prompt' => 'Viloyatni tanlang'
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
        <button class="btn btn-block btn-outline-primary" id="btn-submit" type="submit">Filter</button>
    </div>
</div>
<?= Html::endForm(); ?>
<div class="scores-table">
    <table class="table table-bordered">
        <thead class="thead-light">
        <th>Hudud Nomi</th>
        <th>Score</th>
        </thead>
        <tbody>
        <?php foreach ($scoreValues as $score): ?>
            <tr>
                <td><?= $score['name'] ?></td>
                <td><?= round($score['score_sum'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php foreach ($emptyPlaces as $place): ?>
            <tr>
                <td><?= $place['name'] ?></td>
                <td>0</td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>