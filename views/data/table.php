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
use app\models\ParamType;
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

$this->title = 'Маълумотни киритиш';
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
$numberOfColumns = 0;
$parentColumns = 0;
foreach ($category['categoryParams'] as $categoryParam) {
    if ($categoryParam['param_type_id'] != ParamType::TYPE_FORMULA) {
        $numberOfColumns++;
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
}
?>

<!--filter block-->
<?= $this->render('filter', [
    'categoryId' => $categoryId,
    'regionId' => $regionId,
    'yearId' => $yearId,
    'quarterId' => $quarterId,
    'url' => 'data/table'
]); ?>
<!--filter block-->
<br>
<div>
    <table class="table table-bordered table-striped">
        <thead class="thead-light">
        <tr>
            <th rowspan="<?= $maxChilds ?>">№</th>
            <th rowspan="<?= $maxChilds ?>">Hudud nomi</th>
            <?php foreach ($children as $key => $value): ?>
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
            <th>Action</th>
        </tr>
        <tr>
            <!--Set the values of the second row of the head-->
            <?php foreach ($children as $key => $value): ?>
                <?php if (isset($value['children'])): ?>
                    <?php $parentColumns++; ?>
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
                    <!--Check if the type of the data is not calculated by formula-->
                    <?php if ($value['param']['param_type_id'] != ParamType::TYPE_FORMULA): ?>
                        <td><?= $value['value'] ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td></td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>


        <!--Fill with empty cells if the values are not set-->
        <?php foreach ($emptyPlaces as $place): ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $place['name']; ?></td>
                <?php for ($j = 0; $j < $numberOfColumns - $parentColumns; $j++) {
                    echo '<td>0</td>';
                } ?>
                <td><a class="btn btn-outline-primary" id="addUrl" href="
          <?= Url::to('/data/add?categoryId=' . $categoryId .
                        '&regionId=' . $regionId . '&districtId=' . $place['id'] .
                        '&yearId=' . $yearId . '&quarterId=' . $quarterId) ?>">
                        <i class="fa fa-plus"></i></a></td>
            </tr>
            <?php $i++ ?>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>


