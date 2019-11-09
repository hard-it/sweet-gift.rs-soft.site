<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductType;

/**
 * ProductTypeSearch represents the model behind the search form of `common\models\ProductType`.
 */
class ProductTypeSearch extends ProductType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'Category', 'MinimalQuantity', 'ShelfLife', 'Measure'], 'integer'],
            [['Code', 'Name', 'Description', 'Tags', 'Keywords', 'Images'], 'safe'],
            [['Cost'], 'number'],
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
        $query = ProductType::find();

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
            'Category' => $this->Category,
            'MinimalQuantity' => $this->MinimalQuantity,
            'ShelfLife' => $this->ShelfLife,
            'Measure' => $this->Measure,
            'Cost' => $this->Cost,
        ]);

        $query->andFilterWhere(['like', 'Code', $this->Code])
            ->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Tags', $this->Tags])
            ->andFilterWhere(['like', 'Keywords', $this->Keywords])
            ->andFilterWhere(['like', 'Images', $this->Images]);

        return $dataProvider;
    }

    public function getCategoryList(string $baseCategory = null)
    {
        
    }
}
