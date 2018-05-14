<?php

namespace app\models;

use app\components\MathExpression;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "data".
 *
 * @property int $id
 * @property int $region_id
 * @property int $district_id
 * @property int $category_id
 * @property int $param_id
 * @property float $value
 * @property int $creator
 * @property string $created_at
 * @property int $modifier
 * @property string $modified_at
 * @property int $quarter
 * @property int $year
 *
 * @property Quarter $quarter0
 * @property Category $category
 * @property District $district
 * @property CategoryParams $param
 * @property Region $region
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'district_id', 'category_id', 'param_id', 'year', 'creator', 'modifier', 'quarter'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['value'], 'safe'],
            [['quarter'], 'exist', 'skipOnError' => true, 'targetClass' => Quarter::className(), 'targetAttribute' => ['quarter' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['param_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryParams::className(), 'targetAttribute' => ['param_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'modified_at',
                'value' => function () {
                    return date("Y-m-d H:i:s");
                }
            ]
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->creator = Yii::$app->user->id;
        }
        $this->modifier = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }

    public static function setData($category, &$post)
    {
        $request = Yii::$app->request;
        $categoryId = $request->get("categoryId");
        $regionId = $request->get("regionId");
        $year = $request->get("yearId");
        $quarter = $request->get("quarterId");
        $category = Category::find()->with('categoryParams')->where(['id' => $categoryId])->asArray()->one();


        $i = 3;
        foreach ($category['categoryParams'] as $param) {
            $data = new Data();
            $data->category_id = $categoryId;
            $data->region_id = $regionId;
            $data->district_id = $post["districtId"];
            $data->param_id = $param['id'];
            $data->year = $year;
            $data->quarter = $quarter ? $quarter : Quarter::find()->one()->id;

            if ($param['param_type_id'] == ParamType::TYPE_INPUT) {
                /**
                 * Param type: INPUT (user inputs value)
                 */
                $data->value = $post[$i];

            } else if ($param['param_type_id'] == ParamType::TYPE_FORMULA) {
                /**
                 * Param type: FORMULA, value calculated according to formula
                 */


                $formula = $param['formula'];
                $expr = new MathExpression($formula, $post);
                $expr->calculate();
                $data->value = $expr->getResult();
                $data->value = $data->value > 1 ? 1 : $data->value; // the value shouldn't exceed 100%
                $post[$i] = $data->value;
            }

            if (in_array($param['param_type_id'], [ParamType::TYPE_INPUT, ParamType::TYPE_FORMULA])) {
                $i++;
                $data->save();
            }
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'region_id' => Yii::t('main', 'Region ID'),
            'district_id' => Yii::t('main', 'District ID'),
            'category_id' => Yii::t('main', 'Category ID'),
            'param_id' => Yii::t('main', 'Param ID'),
            'value' => Yii::t('main', 'Value'),
            'creator' => Yii::t('main', 'Creator'),
            'created_at' => Yii::t('main', 'Created At'),
            'modifier' => Yii::t('main', 'Modifier'),
            'modified_at' => Yii::t('main', 'Modified At'),
            'quarter' => Yii::t('main', 'Quarter'),
            'year' => Yii::t('main', 'Year'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuarter0()
    {
        return $this->hasOne(Quarter::className(), ['id' => 'quarter']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParam()
    {
        return $this->hasOne(CategoryParams::className(), ['id' => 'param_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public function getScoreRegion()
    {
        return $this->hasOne(Score::className(), [
            'region_id' => 'region_id',
            'district_id' => '',
            'quarter_id' => 'quarter',
            'category_id' => 'category_id',
            'year' => 'year',
        ]);
    }

    public function getScoreDistrict()
    {
        return $this->hasOne(Score::className(), [
            'region_id' => 'region_id',
            'district_id' => 'district_id',
            'quarter_id' => 'quarter',
            'category_id' => 'category_id',
            'year' => 'year',
        ]);
    }
}
