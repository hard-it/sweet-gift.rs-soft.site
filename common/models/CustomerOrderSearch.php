<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CustomerOrder;

/**
 * CustomerOrderSearch represents the model behind the search form of `common\models\CustomerOrder`.
 */
class CustomerOrderSearch extends CustomerOrder
{
    const DEFAULT_PAGE_SIZE = 20;

    public $pageSize = self::DEFAULT_PAGE_SIZE;

    public $fullName = '';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'Customer'], 'integer'],
            [['Number', 'pageSize', 'fullName'], 'safe'],
            [['Sum'], 'number'],
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
        $query = CustomerOrder::find();

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
        $query->andFilterWhere([
            'Id' => $this->Id,
            'Customer' => $this->Customer,
            'Sum' => $this->Sum,
        ]);

        $query->andFilterWhere(['like', 'Number', $this->Number])
            ->andFilterWhere(['like', 'State', $this->State])
            ->andFilterWhere(['like', 'OrderPoint', $this->OrderPoint])
            ->andFilterWhere(['like', 'OrderPointDescription', $this->OrderPointDescription]);

        return $dataProvider;
    }
}
