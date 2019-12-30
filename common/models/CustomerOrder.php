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
    // дата заказа
    public $RDate;
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Customer'], 'integer'],
            [['RDate', 'State', 'OrderPoint', 'OrderPointDescription'], 'safe'],
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
            'RDate'                 => Yii::t('app', 'Дата заказа'),
            'Customer'              => Yii::t('app', 'Заказчик'),
            'State'                 => Yii::t('app', 'Состояние заказа'),
            'Sum'                   => Yii::t('app', 'Сумма заказа'),
            'OrderPoint'            => Yii::t('app', 'Точка получения заказа'),
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
}
