<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "data_status".
 *
 * @property int $id
 * @property resource $file
 * @property string $filename
 * @property string $filetype
 * @property string $filesize
 * @property int $status
 * @property int $category_id
 * @property int $region_id
 * @property int $year
 * @property int $quarter
 * @property int $creator
 * @property string $created_at
 * @property int $modifier
 * @property string $modified_at
 */
class DataStatus extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'filetype','filesize'], 'string'],
            [['status', 'category_id', 'region_id', 'year', 'quarter', 'creator', 'modifier'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['filename'], 'string', 'max' => 255],
            ['file', 'file', 'extensions' => 'doc, docx, pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'Файл',
            'filename' => 'Filename',
            'status' => 'Status',
            'category_id' => 'Category ID',
            'region_id' => 'Region ID',
            'year' => 'Year',
            'quarter' => 'Quarter',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'modifier' => 'Modifier',
            'modified_at' => 'Modified At',
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
        if ($file = UploadedFile::getInstance($this, 'file')) {
            $this->filename = $file->name;
            $this->filetype = $file->type;
            $this->filesize = $file->size;
            $this->file = file_get_contents($file->tempName);
        }

        if ($this->isNewRecord) {
            $this->creator = Yii::$app->user->id;
        }
        $this->modifier = Yii::$app->user->id;

        return parent::beforeSave($insert);
    }

}
