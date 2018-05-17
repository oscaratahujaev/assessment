<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_ministery".
 *
 * @property int $id
 * @property int $ministery_id
 * @property int $category_id
 * @property int $creator
 * @property string $created_date
 * @property int $modiefier
 * @property string $modiefied_at
 *
 * @property Category $category
 * @property Ministry $ministery
 */
class CategoryMinistery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_ministery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ministery_id', 'category_id', 'creator', 'modiefier'], 'integer'],
            [['created_date', 'modiefied_at'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['ministery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ministry::className(), 'targetAttribute' => ['ministery_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ministery_id' => 'Ministery ID',
            'category_id' => 'Category ID',
            'creator' => 'Creator',
            'created_date' => 'Created Date',
            'modiefier' => 'Modiefier',
            'modiefied_at' => 'Modiefied At',
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
    public function getMinistery()
    {
        return $this->hasOne(Ministry::className(), ['id' => 'ministery_id']);
    }
}
