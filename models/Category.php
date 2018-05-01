<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property int $creator
 * @property string $created_at
 * @property int $modifier
 * @property string $modified_at
 * @property int $ministry_id
 * @property int $place_type
 * @property int $factor_column
 * @property string $score_class
 *
 * @property Ministry $ministry
 * @property CategoryParams[] $categoryParams
 * @property Data[] $datas
 * @property Score[] $scores
 */
class Category extends \yii\db\ActiveRecord
{
    private static $scoreClasses = [
        '1' => 'DefaultScore',
        '2' => 'NeedyScore',
        '3' => 'EnterpriseScore',
        '4' => 'NewEnterpriseScore',
        '5' => 'WorkplaceScore',
        '6' => 'EntrepreneurScore',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creator', 'modifier', 'ministry_id', 'place_type', 'factor_column'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['name', 'score_class'], 'string', 'max' => 255],
            [['ministry_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ministry::className(), 'targetAttribute' => ['ministry_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'modifier' => 'Modifier',
            'modified_at' => 'Modified At',
            'ministry_id' => 'Ministry ID',
            'place_type' => 'Place Type',
            'factor_column' => 'Factor Column',
            'score_class' => 'Score Class',
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

    public function getMinistry()
    {
        return $this->hasOne(Ministry::className(), ['id' => 'ministry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryParams()
    {
        return $this->hasMany(CategoryParams::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatas()
    {
        return $this->hasMany(Data::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScores()
    {
        return $this->hasMany(Score::className(), ['category_id' => 'id']);
    }

    public static function getScoreClassById($id)
    {
        return isset(self::$scoreClasses[$id]) ? self::$scoreClasses[$id] : "";
    }

    public static function getScoreClasses()
    {
        return self::$scoreClasses;
    }
}
