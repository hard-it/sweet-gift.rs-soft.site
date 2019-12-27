<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * CustomerOrderSearch represents the model behind the search form of `common\models\CustomerOrder`.
 */
class CustomerOrderSearch extends CustomerOrder
{
    const DEFAULT_PAGE_SIZE = 20;

    public $pageSize = self::DEFAULT_PAGE_SIZE;

    public $fullName = '';

    public $TDate = [];

    public $RDate;

    public $FullTDate = '';


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'Customer'], 'integer'],
            [['Number', 'pageSize', 'fullName', 'TDate', 'RDate', 'FullTDate'], 'safe'],
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $oldAttrs = parent::attributeLabels();
        $newAttrs = [
            'RDate'    => Yii::t('app', 'Дата заказа'),
            'TDate'    => Yii::t('app', 'Время получения'),
            'fullName' => Yii::t('app', 'Заказчик'),
        ];

        return ArrayHelper::merge($oldAttrs, $newAttrs);
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
            'Id'       => $this->Id,
            'Customer' => $this->Customer,
            'Sum'      => $this->Sum,
        ]);

        $query->andFilterWhere(['like', 'Number', $this->Number])
            ->andFilterWhere(['like', 'State', $this->State])
            ->andFilterWhere(['like', 'OrderPoint', $this->OrderPoint])
            ->andFilterWhere(['like', 'OrderPointDescription', $this->OrderPointDescription]);

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
        $query = CustomerOrder::find();

        // add conditions that should always apply here

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
}
