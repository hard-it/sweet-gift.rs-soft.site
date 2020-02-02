<?php

namespace common\models;

use Yii;
use sjaakp\spatial\ActiveQuery;
use sjaakp\spatial\ActiveRecord;

/**
 * This is the model class for table "CustomerOrder".
 *
 * @property int      $Id                    Идентификатор записи
 * @property string   $Number                Номер заказа
 * @property int      $Customer              Заказчик
 * @property Customer $customer0             Заказчик
 * @property array    $State                 Состояние заказа
 * @property string   $Sum                   Сумма заказа
 * @property array    $OrderPoint            Точка получения заказа
 * @property array    $OrderPointDescription Описание точки получения заказа
 */
class CustomerOrder extends ActiveRecord
{
    const ORDER_PRODUCT_ID           = 'id';
    const ORDER_PRODUCT_PRODUCT_TYPE = 'product_type';
    const ORDER_PRODUCT_COST         = 'cost';
    const ORDER_PRODUCT_QUANTITY     = 'quantity';
    const ORDER_PRODUCT_SUM          = 'sum';
    const ORDER_PRODUCT_COMMENT      = 'comment';
    const ORDER_PRODUCT_PRICE        = 'price';

    /**
     * Список продуктов для заказа
     * @var array
     */
    public $productData = [];


    /**
     * копия данных о заказчике
     * @var Customer|null
     */
    protected $customerData = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'CustomerOrder';
    }

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->State = [
            [
                CustomerOrderState::ORDER_FIELD_AT          => time(),
                CustomerOrderState::ORDER_FIELD_STATE       => CustomerOrderState::ORDER_STATE_CREATED,
                CustomerOrderState::ORDER_FIELD_DESCRIPTION => '',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Customer'], 'integer'],
            [['State', 'OrderPoint', 'OrderPointDescription', 'customerData', 'productData'], 'safe'],
            [['Sum'], 'number'],
            [['Number'], 'string', 'max' => 20],
            [['Number'], 'unique'],
            [['Customer', 'Number'], 'unique', 'targetAttribute' => ['Customer', 'Number']],
            [['Customer'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['Customer' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id'                    => Yii::t('app', 'Идентификатор записи'),
            'Number'                => Yii::t('app', 'Номер заказа'),
            'Customer'              => Yii::t('app', 'Заказчик'),
            'State'                 => Yii::t('app', 'Состояние заказа'),
            'Sum'                   => Yii::t('app', 'Сумма заказа'),
            'OrderPoint'            => Yii::t('app', 'Точка получения заказа'),
            'productData'           => Yii::t('app', 'Товары'),
            'OrderPointDescription' => Yii::t('app', 'Описание точки получения заказа'),
        ];
    }

    /**
     * @return Customer
     */
    public function getCustomer0()
    {
        if (isset($this->customerData)) {
            return $this->customerData;
        }

        return $this->hasOne(Customer::class, ['Id' => 'Customer']);
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function setCustomer0($data)
    {
        $this->customerData = $this->getCustomer0() ?? new Customer();

        $this->customerData->load($data, '');

        return $this;
    }

    /**
     * @return ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, ['Order' => 'Id']);
    }

    /**
     * @return CustomerOrderStateCollection
     */
    public function getStateCollection(): CustomerOrderStateCollection
    {
        return new CustomerOrderStateCollection($this->State);
    }

    /**
     * @param CustomerOrderStateCollection $state
     *
     * @return $this
     */
    public function setStateCollection(CustomerOrderStateCollection $state)
    {
        $this->State = $state->toArray();

        return $this;
    }


    /**
     * {@inheritdoc}
     * @return CustomerOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerOrderQuery(get_called_class());
    }

    /**
     * @return array
     */
    protected function loadProductData()
    {
        $products = $this->getOrderProducts();

        $this->productData = [];

        /**
         * @var OrderProduct $product
         */
        foreach ($products as $product) {
            $row = [
                static::ORDER_PRODUCT_ID           => $product->Id,
                static::ORDER_PRODUCT_PRODUCT_TYPE => $product->Product,
                static::ORDER_PRODUCT_COST         => $product->Cost,
                static::ORDER_PRODUCT_QUANTITY     => $product->Quantity,
                static::ORDER_PRODUCT_SUM          => $product->Sum,
                static::ORDER_PRODUCT_COMMENT      => $product->Comment,
            ];

            $this->productData[] = $row;
        }

        return $this->productData;
    }
}
