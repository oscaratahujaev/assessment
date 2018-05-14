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


$parents = [];
$categorySorted = [];
$children = [];
/**
 * maxchildren is necessary setting the colspan
 * */
$maxChilds = 1;
$i = 1;
/**
 * number of all columns in the head, parents columns are the ones that were used as parent_id
 * */
$numberOfColumns = 0;
$parentColumns = 0;

/**
 * find out the children of the parents, these are necessary for setting the head of the table
 * */
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
    'url' => 'data/statistics'
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
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
        <!--Fill in with empty cells if values are not set-->
        <?php foreach ($emptyPlaces as $place): ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $place['name']; ?></td>
                <?php for ($j = 0; $j < $numberOfColumns - $parentColumns; $j++) {
                    echo '<td>0</td>';
                } ?>
            </tr>
            <?php $i++ ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p>

    </p>
</div>

