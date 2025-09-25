<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;
use app\models\PetVaccine;

/**
 * PetVaccineSearch represents the model behind the search form of `app\models\PetVaccine`.
 */
class PetVaccineSearch extends PetVaccine
{
    /**
     * {@inheritdoc}
     */

    public $pet_id;
    public $petName;
    public $vaccineName;

    public function rules()
    {
        return [
            [['pet_vaccine_id', 'pet_id', 'vaccine_id'], 'integer'],
            [['date_given', 'notes', 'petName', 'vaccineName'], 'safe'],
            [['notes'], 'string', 'max' => 2009],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PetVaccine::find()->joinWith('pet')->joinWith('vaccine');

        // add conditions that should always apply here

        if (Yii::$app->user->identity->role === 'user') {
            $query->andWhere(['pet.user_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'pet.name', $this->petName])
            ->andFilterWhere([
                'pet_vaccine_id' => $this->pet_vaccine_id,
                'pet_id' => $this->pet_id,
                'vaccine_id' => $this->vaccine_id,
                'date_given' => $this->date_given,
            ]);

        $query->andFilterWhere(['like', 'notes', $this->notes]);
        $query->andFilterWhere(['like', 'vaccine.name', $this->vaccineName]);
        if ($this->pet_id) {
            $query->andWhere(['pet_id' => $this->pet_id]);
        }

        return $dataProvider;
    }
}
