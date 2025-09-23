<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "photo".
 *
 * @property int $photo_id
 * @property string $path
 * @property int $pet_id
 *
 * @property Pet $pet
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $files;
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'pet_id'], 'required'],
            [['pet_id'], 'integer'],
            [['path'], 'string', 'max' => 512],
            [['pet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::class, 'targetAttribute' => ['pet_id' => 'pet_id']],
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10, 'on' => 'create'],
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 1, 'on' => 'update'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'photo_id' => 'Photo ID',
            'path' => 'Path',
            'files' => 'Photo(s)',
            'pet_id' => 'Pet',
        ];
    }

    /**
     * Gets query for [[Pet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPet()
    {
        return $this->hasOne(Pet::class, ['pet_id' => 'pet_id']);
    }
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        // ...custom code here...
        if($this->path){
            $photoPathOld = Yii::$app->basePath.'/web/'.$this->path; //get the path to the existing file
            @unlink($photoPathOld);
        }
        return true;
    }

}
