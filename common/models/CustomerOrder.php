<?php

namespace common\models;

use Yii;
use sjaakp\spatial\ActiveQuery;
use sjaakp\spatial\ActiveRecord;
use common\models\traits\Points;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'CustomerOrder';
    }

    use Points;

    protected $geoPointName = 'OrderPoint';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Customer'], 'integer'],
            [['State', 'OrderPoint', 'OrderPointDescription'], 'safe'],
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
            'OrderPointDescription' => Yii::t('app', 'Описание точки получения заказа'),


        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomer0()
    {
        return $this->hasOne(Customer::class, ['Id' => 'Customer']);
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
