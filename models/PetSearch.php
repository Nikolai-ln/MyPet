<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;
use app\models\Pet;

/**
 * PetSearch represents the model behind the search form of `app\models\Pet`.
 */
class PetSearch extends Pet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pet_id', 'user_id'], 'integer'],
            [['name', 'type', 'breed', 'date_of_birth', 'information', 'owner', 'address'], 'safe'],
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
    public function search($params, $query = null)
    {
        if ($query === null) {
            $query = Pet::find();
        }

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

        if (Yii::$app->user->identity->role !== 'admin') {
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pet_id' => $this->pet_id,
            'date_of_birth' => $this->date_of_birth,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'breed', $this->breed])
            ->andFilterWhere(['like', 'information', $this->information])
            ->andFilterWhere(['like', 'owner', $this->owner])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
