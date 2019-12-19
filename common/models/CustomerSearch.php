<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

/**
 * CustomerSearch represents the model behind the search form of `common\models\Customer`.
 */
class CustomerSearch extends Customer
{
    const DEFAULT_PAGE_SIZE = 20;

    public $pageSize = self::DEFAULT_PAGE_SIZE;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'User'], 'integer'],
            [['Phone', 'Firstname', 'Lastname', 'pageSearch'], 'safe'],
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
        $query = Customer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => $this->pageSize ?? static::DEFAULT_PAGE_SIZE,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        /*
        $query->andFilterWhere([
            'Id' => $this->Id,
            'User' => $this->User,
        ]);
        */

        $query->andFilterWhere(['like', 'Phone', $this->Phone])
            ->andFilterWhere(['like', 'Firstname', $this->Firstname])
            ->andFilterWhere(['like', 'Lastname', $this->Lastname]);

        return $dataProvider;
    }
}
