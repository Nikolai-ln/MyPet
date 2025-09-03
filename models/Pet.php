<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pet".
 *
 * @property int $pet_id
 * @property string $name
 * @property string $type
 * @property string|null $breed
 * @property string|null $date_of_birth
 * @property string|null $information
 * @property string|null $owner
 * @property string|null $address
 * @property int|null $user_id
 *
 * @property PetVaccine[] $petVaccines
 * @property Photo[] $photos
 * @property User $user
 */
class Pet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['date_of_birth'], 'safe'],
            [['user_id'], 'integer'],
            [['name', 'type', 'breed'], 'string', 'max' => 55],
            [['information'], 'string', 'max' => 2009],
            [['owner'], 'string', 'max' => 111],
            [['address'], 'string', 'max' => 125],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pet_id' => 'Pet ID',
            'name' => 'Name',
            'type' => 'Type',
            'breed' => 'Breed',
            'date_of_birth' => 'Date Of Birth',
            'information' => 'Information',
            'owner' => 'Owner names',
            'address' => 'Address',
            'user_id' => 'Owner username',
        ];
    }

    /**
     * Gets query for [[PetVaccines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPetVaccines()
    {
        return $this->hasMany(PetVaccine::class, ['pet_id' => 'pet_id']);
    }

    /**
     * Gets query for [[Photos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::class, ['pet_id' => 'pet_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }
}
