<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "category_params".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property int $param_type_id
 * @property int $parent_id
 * @property int $creator
 * @property string $created_at
 * @property int $modifier
 * @property string $modified_at
 * @property string $formula
 *
 * @property Category $category
 * @property ParamType $paramType
 * @property Data[] $datas
 */
class CategoryParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_params';
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
    public function rules()
    {
        return [
            [['category_id', 'param_type_id', 'parent_id', 'creator', 'modifier'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['name', 'formula'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['param_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ParamType::className(), 'targetAttribute' => ['param_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'category_id' => Yii::t('main', 'Category ID'),
            'name' => Yii::t('main', 'Name'),
            'param_type_id' => Yii::t('main', 'Param Type ID'),
            'parent_id' => Yii::t('main', 'Parent ID'),
            'creator' => Yii::t('main', 'Creator'),
            'created_at' => Yii::t('main', 'Created At'),
            'modifier' => Yii::t('main', 'Modifier'),
            'modified_at' => Yii::t('main', 'Modified At'),
            'formula' => Yii::t('main', 'Formula'),
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
    public function getParamType()
    {
        return $this->hasOne(ParamType::className(), ['id' => 'param_type_id']);
    }

    public function getParent()
    {
        return $this->hasOne(CategoryParams::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatas()
    {
        return $this->hasMany(Data::className(), ['param_id' => 'id']);
    }
}
