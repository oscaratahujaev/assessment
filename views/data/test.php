<?php
/**
 * Created by PhpStorm.
 * User: m_toshpolatov
 * Date: 30.04.2018
 * Time: 15:16
 */
?>

<tr>
    <th rowspan="2" colspan="1">Худуд номи</th>
    <?php foreach ($category['categoryParams'] as $cParam): ?>
        <?php if (is_null($cParam['parent_id'])): ?>
            <?php if (!in_array($cParam['id'], $parents)): ?>
                <th rowspan="2" colspan="1">
                    <?= $cParam['name'] ?>
                </th>
            <?php else: ?>
                <td rowspan="1" colspan="2">
                    <strong><?= $cParam['name'] ?></strong>
                </td>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <th rowspan="2" colspan="1">Score</th>
</tr>
<tr>
    <?php foreach ($category['categoryParams'] as $cParamChild): ?>
        <?php if (!is_null($cParamChild['parent_id'])): ?>
            <td rowspan="1" colspan="1">
                <?= $cParamChild['name'] ?>
            </td>
        <?php endif; ?>
    <?php endforeach; ?>
</tr>

