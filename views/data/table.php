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
<p>
    <?php $form = ActiveForm::begin(['method' => 'GET', 'action' => Url::to(['data/table'])]); ?>
    <?= Html::dropDownList('categoryId', $categoryId,
        ArrayHelper::map($categories, 'id', 'name'),
        ['class' => 'form-control', 'id' => 'category']); ?>
    <br>

</p>
<div>
    <?= Html::dropDownList('regionId', $regionId,
        ArrayHelper::map($regions, 'id', 'name'),
        [
            'prompt' => 'Select Region',
            'class' => 'col-md-3',
            'id' => 'region'
        ]
    ); ?>
    <?= Html::dropDownList('yearId', $yearId,
        ArrayHelper::map($year, 'year', 'year'),
        [
            'prompt' => 'Select Year',
            'class' => 'col-md-3',
            'id' => 'year'
        ]
    ); ?>
    <?= Html::dropDownList('quarterId', $quarterId,
        ArrayHelper::map($quarter, 'id', 'name'),
        [
            'class' => 'col-md-3',
            'id' => 'quarter'
        ]
    ); ?>
</div>
<button class="btn btn-success" type="submit">Filter</button>
<?php ActiveForm::end() ?>

<div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <td rowspan="<?= $maxChilds ?>">№</td>
            <td rowspan="<?= $maxChilds ?>">Hudud nomi</td>
            <?php foreach ($children as $key => $value): ?>
                <?php $numberOfColumns++ ?>
                <?php if (isset($value['children'])): ?>
                    <td colspan="<?= sizeof($value['children']) ?>">
                        <?= $value['name'] ?>
                    </td>
                <?php else: ?>
                    <td rowspan="<?= $maxChilds ?>">
                        <?= $value['name'] ?>
                    </td>
                <?php endif; ?>

            <?php endforeach; ?>
            <td rowspan="<?= $maxChilds ?>">Score</td>
            <td rowspan="<?= $maxChilds ?>">Action</td>
        </tr>
        <tr>
            <?php foreach ($children as $key => $value): ?>
                <?php $numberOfColumns++ ?>
                <?php if (isset($value['children'])): ?>
                    <?php foreach ($value['children'] as $childItem): ?>
                        <td>
                            <?= $childItem['name'] ?>
                        </td>
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
                <td><a class="btn btn-primary" id="addUrl" href="
          <?= Url::to('/data/add?categoryID=' . $categoryId .
                        '&regionID=' . $regionId . '&districtID=' . $place['id'] .
                        '&year=' . $yearId . '&quarter=' . $quarterId) ?>">
                        <i class="glyphicon glyphicon-plus"></i></a></td>
            </tr>
            <?php $i++ ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p>

    </p>
</div>


