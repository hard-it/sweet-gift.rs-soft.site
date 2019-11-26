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
    const DEFAULT_PAGE_SIZE = 20;

    public $pageSize = self::DEFAULT_PAGE_SIZE;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'MinimalQuantity', 'ShelfLife', 'Measure'], 'integer'],
            [['pageSize', 'Category', 'Code', 'Name', 'Description', 'Tags', 'Keywords', 'Images'], 'safe'],
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
        $query = ProductType::find()->alias('producttype');

        $query->joinWith('category0 category0');

        $this->load($params);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => $this->pageSize ?? static::DEFAULT_PAGE_SIZE,
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'producttype.Code', $this->Code])
            ->andFilterWhere(['like', 'producttype.Name', $this->Name]);

        $this->setCategoryFilter($query);

        $txt = $query->createCommand()->getRawSql();

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function cleanSearch($params)
    {
        $query = ProductType::find();

        $query->joinWith('category0 category0');

        $this->pageSize = $params[static::class]['pageSize'] ?? static::DEFAULT_PAGE_SIZE;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => $this->pageSize ?? static::DEFAULT_PAGE_SIZE,
            ],
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

        $query->andFilterWhere(['IN', 'producttype.Category', $cats]);

    }
}
