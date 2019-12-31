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

    public $TDate = [];

    public $FullTDate = '';

    public $Phone;

    public $Firstname;

    public $Lastname;

    public $StateRange = CustomerOrderState::ORDER_STATE_ALL;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'Customer', 'StateRange'], 'integer'],
            [['Number', 'pageSize', 'Firstname', 'Lastname', 'Phone', 'TDate', 'RDate'], 'safe'],
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
            'RDate'      => Yii::t('app', 'Дата заказа'),
            'TDate'      => Yii::t('app', 'Время получения'),
            'Phone'      => Yii::t('app', 'Телефон'),
            'Firstname'  => Yii::t('app', 'Имя'),
            'Lastname'   => Yii::t('app', 'Фамилия'),
            'StateRange' => Yii::t('app', 'Состояние'),
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
            //->andFilterWhere(['like', 'State', $this->State])
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

    /**
     * @return array
     */
    public static function getStateRangeList()
    {
        return [
            CustomerOrderState::ORDER_STATE_ALL      => Yii::t('app', 'Все'),
            CustomerOrderState::ORDER_STATE_CREATED  => Yii::t('app', 'Заказанные'),
            CustomerOrderState::ORDER_STATE_MADE     => Yii::t('app', 'Сделанные'),
            CustomerOrderState::ORDER_STATE_PACKED   => Yii::t('app', 'Упакованные'),
            CustomerOrderState::ORDER_STATE_DELIVERY => Yii::t('app', 'В доставке'),
            CustomerOrderState::ORDER_STATE_HANDED   => Yii::t('app', 'Вручённые'),
            CustomerOrderState::ORDER_STATE_CANCELED => Yii::t('app', 'Отменённые'),
        ];
    }
}
