<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
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

    public function rules()
    {
        return [
            [['pet_vaccine_id', 'pet_id', 'vaccine_id'], 'integer'],
            [['date_given', 'notes'], 'safe'],
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
        $query = PetVaccine::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'pet_vaccine_id' => $this->pet_vaccine_id,
        //     'pet_id' => $this->pet_id,
        //     'vaccine_id' => $this->vaccine_id,
        //     'date_given' => $this->date_given,
        // ]);

        // $query->andFilterWhere(['like', 'notes', $this->notes]);
        if ($this->pet_id) {
            $query->andWhere(['pet_id' => $this->pet_id]);
        }

        return $dataProvider;
    }
}
