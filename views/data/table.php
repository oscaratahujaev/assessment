<?php
/**
 * Created by PhpStorm.
 * User: m_toshpolatov
 * Date: 23.04.2018
 * Time: 10:02
 *
 */
use app\models\Category;
use app\models\District;
use app\models\Quarter;
use app\models\Region;
use app\models\Years;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 *$category Category;
 * */
$categories = Category::find()->all();
$regions = Region::find()->all();
$district = District::find()->all();
$quarter = Quarter::find()->all();
$year = Years::find()->all();

$parents = [];
$categorySorted = [];
$children = [];
$maxChilds = 1;
$i = 1;
$numberOfColumns = -1;
foreach ($category['categoryParams'] as $categoryParam) {
    if (is_null($categoryParam['parent_id'])) {
        $children[$categoryParam['id']] = [
            'name' => $categoryParam['name'],
        ];

    } else {

        if (isset($children[$categoryParam['parent_id']])) {
            $children[$categoryParam['parent_id']]['children'][] = [
                'name' => $categoryParam['name'],
            ];
        } else {
            $children[$categoryParam['parent_id']] = [
                'children' => [
                    'name' => $categoryParam['name'],
                ]
            ];
        }
        $tmp = sizeof($children[$categoryParam['parent_id']]['children']);
        $maxChilds = $maxChilds < $tmp ? $tmp : $maxChilds;
    }
}
?>

<?php $form = ActiveForm::begin(['method' => 'GET', 'action' => Url::to(['data/table'])]); ?>
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
                'class' => 'form-control'
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

<?php ActiveForm::end() ?>
<br>
<div>
    <table class="table table-bordered table-striped">
        <thead class="thead-light">
        <tr>
            <th rowspan="<?= $maxChilds ?>">№</th>
            <th rowspan="<?= $maxChilds ?>">Hudud nomi</th>
            <?php foreach ($children as $key => $value): ?>
                <?php $numberOfColumns++ ?>
                <?php if (isset($value['children'])): ?>
                    <th colspan="<?= sizeof($value['children']) ?>">
                        <?= $value['name'] ?>
                    </th>
                <?php else: ?>
                    <th rowspan="<?= $maxChilds ?>">
                        <?= $value['name'] ?>
                    </th>
                <?php endif; ?>

            <?php endforeach; ?>
            <th rowspan="<?= $maxChilds ?>">Score</th>
            <th rowspan="<?= $maxChilds ?>">Action</th>
        </tr>
        <tr>
            <?php foreach ($children as $key => $value): ?>
                <?php $numberOfColumns++ ?>
                <?php if (isset($value['children'])): ?>
                    <?php foreach ($value['children'] as $childItem): ?>
                        <th>
                            <?= $childItem['name'] ?>
                        </th>
                    <?php endforeach; ?>
                <?php endif; ?>

            <?php endforeach; ?>
        </tr>

        </thead>
        <tbody>

        <?php foreach ($data as $item): ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $item['place'] ?></td>
                <?php foreach ($item['values'] as $value): ?>
                    <td><?= $value ?></td>
                <?php endforeach; ?>
                <td><?= $item['score'] ?></td>
                <td></td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
        <?php foreach ($emptyPlaces as $place): ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $place['name']; ?></td>
                <?php for ($j = 2; $j < $numberOfColumns; $j++) {
                    echo '<td></td>';
                } ?>
                <td><a class="btn btn-outline-primary" id="addUrl" href="
          <?= Url::to('/data/add?categoryId=' . $categoryId .
                        '&regionId=' . $regionId . '&districtId=' . $place['id'] .
                        '&year=' . $yearId . '&quarter=' . $quarterId) ?>">
                        <i class="fa fa-plus"></i></a></td>
            </tr>
            <?php $i++ ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p>

    </p>
</div>


