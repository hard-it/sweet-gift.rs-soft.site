<?php

namespace common\models;

use common\models\ProductType;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
            [['Id', 'MinimalQuantity', 'ShelfLife', 'Measure'], 'integer'],
            [['Category', 'Code', 'Name', 'Description', 'Tags', 'Keywords', 'Images'], 'safe'],
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
            //'Category' => $this->Category,
            'MinimalQuantity' => $this->MinimalQuantity,
            'ShelfLife' => $this->ShelfLife,
            //'Measure' => $this->Measure,
            'Cost' => $this->Cost,
        ]);

        $query->andFilterWhere(['like', 'Code', $this->Code])
            ->andFilterWhere(['like', 'Name', $this->Name]);

        $this->setCategoryFilter($query);

        //$txt = $query->createCommand()->getRawSql();

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function cleanSearch()
    {
        $query = ProductType::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$txt = $query->createCommand()->getRawSql();

        return $dataProvider;
    }

    /**
     * @param ProductTypeQuery $query
     */
    public function setCategoryFilter(ProductTypeQuery $query)
    {
        if (!isset($this->Category) || !strlen($this->Category)) {
            return;
        }

        $cats = explode(',', $this->Category);

        $query->andFilterWhere(['IN', 'Category', $cats]);

    }
}
