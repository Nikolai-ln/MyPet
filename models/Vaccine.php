<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vaccine".
 *
 * @property int $vaccine_id
 * @property string $name
 * @property string|null $description
 *
 * @property PetVaccine[] $petVaccines
 */
class Vaccine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vaccine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 2009],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vaccine_id' => 'Vaccine ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[PetVaccines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPetVaccines()
    {
        return $this->hasMany(PetVaccine::class, ['vaccine_id' => 'vaccine_id']);
    }
}
