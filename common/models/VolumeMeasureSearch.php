<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VolumeMeasureSearch represents the model behind the search form of `common\models\VolumeMeasure`.
 */
class VolumeMeasureSearch extends VolumeMeasure
{
    const DEFAULT_PAGE_SIZE = 20;

    public $pageSize = self::DEFAULT_PAGE_SIZE;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id'], 'integer'],
            [['ShortName', 'OneName', 'SomeName', 'ManyName', 'pageSize'], 'safe'],
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
        $query = VolumeMeasure::find();

        // add conditions that should always apply here

        $this->load($params);

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

        $query->andFilterWhere(['like', 'ShortName', $this->ShortName])
            ->andFilterWhere(['like', 'OneName', $this->OneName])
            ->andFilterWhere(['like', 'SomeName', $this->SomeName])
            ->andFilterWhere(['like', 'ManyName', $this->ManyName]);

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
        $query = VolumeMeasure::find();

        // add conditions that should always apply here

        $this->pageSize = $params[static::class]['pageSize'] ?? static::DEFAULT_PAGE_SIZE;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => $this->pageSize ?? static::DEFAULT_PAGE_SIZE,
            ],
        ]);

        return $dataProvider;
    }
}
