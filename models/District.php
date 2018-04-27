<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "district".
 *
 * @property int $id
 * @property string $name
 * @property int $region_id
 * @property int $creator
 * @property string $created_at
 * @property int $modifier
 * @property int $place_type
 * @property string $modified_at
 *
 * @property Data[] $datas
 * @property Region $region
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'creator', 'modifier', 'place_type'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'name' => Yii::t('main', 'Name'),
            'region_id' => Yii::t('main', 'Region ID'),
            'creator' => Yii::t('main', 'Creator'),
            'created_at' => Yii::t('main', 'Created At'),
            'modifier' => Yii::t('main', 'Modifier'),
            'modified_at' => Yii::t('main', 'Modified At'),
            'place_type' => Yii::t('main', 'Place Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatas()
    {
        return $this->hasMany(Data::className(), ['district_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
}
