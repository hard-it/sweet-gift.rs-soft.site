<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\VolumeMeasure;

/**
 * VolumeMeasureSearch represents the model behind the search form of `common\models\VolumeMeasure`.
 */
class VolumeMeasureSearch extends VolumeMeasure
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id'], 'integer'],
            [['ShortName', 'OneName', 'SomeName', 'Many'], 'safe'],
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
        ]);

        $query->andFilterWhere(['like', 'ShortName', $this->ShortName])
            ->andFilterWhere(['like', 'OneName', $this->OneName])
            ->andFilterWhere(['like', 'SomeName', $this->SomeName])
            ->andFilterWhere(['like', 'Many', $this->Many]);

        return $dataProvider;
    }
}
