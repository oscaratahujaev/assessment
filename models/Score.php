<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "score".
 *
 * @property int $id
 * @property int $region_id
 * @property int $district_id
 * @property int $quarter_id
 * @property int $category_id
 * @property int $creator
 * @property int $created_at
 * @property int $modifier
 * @property int $modfied_at
 * @property float $value
 * @property int $year
 *
 * @property Category $category
 * @property District $district
 * @property Quarter $quarter
 * @property Region $region
 */
class Score extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'score';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['district_id'], 'safe'],
            [['created_at', 'modfied_at'], 'safe'],
            [['value'], 'safe'],
            [['region_id', 'district_id', 'quarter_id', 'category_id', 'creator', 'created_at', 'modifier', 'year'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['quarter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quarter::className(), 'targetAttribute' => ['quarter_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'modfied_at',
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'region_id' => Yii::t('main', 'Region ID'),
            'district_id' => Yii::t('main', 'District ID'),
            'quarter_id' => Yii::t('main', 'Quarter ID'),
            'category_id' => Yii::t('main', 'Category ID'),
            'creator' => Yii::t('main', 'Creator'),
            'created_at' => Yii::t('main', 'Created At'),
            'modifier' => Yii::t('main', 'Modifier'),
            'modfied_at' => Yii::t('main', 'Modfied At'),
            'year' => Yii::t('main', 'Year'),
        ];
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
    public function getQuarter()
    {
        return $this->hasOne(Quarter::className(), ['id' => 'quarter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
}
