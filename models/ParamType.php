<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "param_type".
 *
 * @property int $id
 * @property string $name
 * @property int $creator
 * @property string $created_at
 * @property int $modifier
 * @property string $modified_at
 *
 * @property CategoryParams[] $categoryParams
 */
class ParamType extends \yii\db\ActiveRecord
{
    const TYPE_INPUT = 1;
    const TYPE_FORMULA = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'param_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creator', 'modifier'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'creator' => Yii::t('main', 'Creator'),
            'created_at' => Yii::t('main', 'Created At'),
            'modifier' => Yii::t('main', 'Modifier'),
            'modified_at' => Yii::t('main', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryParams()
    {
        return $this->hasMany(CategoryParams::className(), ['param_type_id' => 'id']);
    }
}
