<?php

namespace common\models;

use Yii;


/**
 * This is the model class for table "CustomerOrder".
 *
 * @property int      $Id                    Идентификатор записи
 * @property string   $Number                Номер заказа
 * @property int      $Customer              Заказчик
 * @property Customer $customer0             Заказчик
 * @property array    $State                 Состояние заказа
 * @property float    $Sum                   Сумма заказа
 * @property array    $OrderPoint            Точка получения заказа
 * @property array    $OrderPointDescription Описание точки получения заказа
 */
class CustomerOrder extends BaseActiveRecord
{
    const ORDER_PRODUCT_ID           = 'Id';
    const ORDER_PRODUCT_PRODUCT_TYPE = 'Product';
    const ORDER_PRODUCT_COST         = 'Cost';
    const ORDER_PRODUCT_QUANTITY     = 'Quantity';
    const ORDER_PRODUCT_SUM          = 'Sum';
    const ORDER_PRODUCT_COMMENT      = 'Comment';

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
            [['customer0'], 'safe'],
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
        $this->customerData = $this->hasOne(Customer::class, ['Id' => 'Customer']);

        return $this->customerData;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        $customer = $this->getCustomer0()->one();

        $result = isset($customer) ? $customer->fullName : '';

        return $result;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function setCustomer0($data)
    {
        $this->customerData = Customer::findOne($data['Id']) ?? new Customer();

        $this->customerData->load($data, '');

        return $this;
    }

    /**
     * @return ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, ['CustomerOrder' => 'Id']);
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
     * @return array
     */
    public function loadProductData()
    {
        $products = $this->getOrderProducts()->all();

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

    /**
     * @return string
     */
    public function getFullname()
    {
        $result   = '';
        $customer = $this->getCustomer0();
        if (isset($customer)) {
            $customer = $customer->one();
            $result = trim(
                ($customer->Firstname ?? '')
                . ' '
                . ($customer->Lastname ?? '')
            );
        }

        return $result;
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        try {
            $transaction = static::getDb()->beginTransaction();

            $this->Sum = $this->calcOrderTotal();

            if (isset($this->customerData) && !$this->customerData->save($runValidation, $attributeNames)) {
                $transaction->rollBack();

                return false;
            }

            if (isset($this->customerData)) {
                $this->Customer = $this->customerData->Id;
            }

            if (!parent::save($runValidation, $attributeNames)) {
                $transaction->rollBack();

                return false;
            }

            if (!$this->saveProductData()) {
                $transaction->rollBack();

                return false;
            }

            $transaction->commit();

        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
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
     * @return float|int
     */
    protected function calcOrderTotal()
    {
        $result = 0;

        foreach ($this->productData as $productDatum) {
            $curSum = round($productDatum[static::ORDER_PRODUCT_SUM], 2) ?? 0;
            $result += $curSum ? $curSum : 0;
        }

        return $result;
    }

    /**
     * @return bool
     */
    protected function saveProductData()
    {
        static::getDb()
            ->createCommand()
            ->delete(OrderProduct::tableName(), ['CustomerOrder' => $this->Id])
            ->execute();

        foreach ($this->productData as $productDatum) {
            $product = new OrderProduct();
            $product->load($productDatum, '');
            $product->CustomerOrder = $this->Id;
            if (!$product->save()) {
                return false;
            }
        }

        return true;
    }

}
