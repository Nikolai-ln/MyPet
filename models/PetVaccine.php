<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pet_vaccine".
 *
 * @property int $pet_vaccine_id
 * @property int $pet_id
 * @property int $vaccine_id
 * @property string $date_given
 * @property string $notes
 *
 * @property Pet $pet
 * @property Vaccine $vaccine
 */
class PetVaccine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pet_vaccine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pet_id', 'vaccine_id', 'date_given'], 'required'],
            [['pet_id', 'vaccine_id'], 'integer'],
            [['date_given'], 'safe'],
            [['notes'], 'string', 'max' => 2009],
            [['pet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::class, 'targetAttribute' => ['pet_id' => 'pet_id']],
            [['vaccine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vaccine::class, 'targetAttribute' => ['vaccine_id' => 'vaccine_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pet_vaccine_id' => 'Pet Vaccine ID',
            'pet_id' => 'Pet ID',
            'vaccine_id' => 'Vaccine ID',
            'date_given' => 'Date Given',
            'notes' => 'Notes',
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

    /**
     * Gets query for [[Vaccine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVaccine()
    {
        return $this->hasOne(Vaccine::class, ['vaccine_id' => 'vaccine_id']);
    }
}
