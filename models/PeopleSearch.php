<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\People;

/**
 * PeopleSearch represents the model behind the search form of `app\models\People`.
 */
class PeopleSearch extends People
{

    public $age;
    public $age_interval = '';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'gender'], 'integer'],
            ['age', 'number', 'max' => 100, 'message' => 'age must not exceed 100 years'],
            ['birthDate', 'datetime', 'format' => 'yyyy-mm-dd'],
            [['firstname', 'lastname', 'email'], 'safe'],
            ['age_interval', 'string', 'max' => 7]
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
        $query = People::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => ($this->category_id == 0) ? '' : $this->category_id,
            'gender' => ($this->gender == 0) ? '' : $this->gender,
            'birthDate' => $this->birthDate,
        ]);

        if (!empty($this->age)) {
            $query->andWhere(['<', 'birthDate', date('Y-m-d', strtotime("-{$this->age} year"))]);
            $query->andWhere(['>', 'birthDate', date('Y-m-d', strtotime("-".($this->age + 1)." year"))]);
        }

        if (!empty($this->age_interval)) {
            list($start,$stop) = array_map('intval', explode(',', $this->age_interval));
            $query->andWhere(['<', 'birthDate', date('Y-m-d', strtotime("-{$start} year"))]);
            $query->andWhere(['>', 'birthDate', date('Y-m-d', strtotime("-".($stop)." year"))]);
        }

//        $query->andFilterWhere(['like', 'firstname', $this->firstname])
//            ->andFilterWhere(['like', 'lastname', $this->lastname])
//            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
