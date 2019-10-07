<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "CustomerOrder".
 *
 * @property int      $Id         Идентификатор записи
 * @property string   $Number     Номер заказа
 * @property int      $Customer   Заказчик
 * @property Customer $customer0  Заказчик
 * @property array    $Delivery   Информация о доставке
 * @property int      $State      Состояние заказа
 * @property string   $Sum        Сумма заказа
 * @property int      $CreatedAt  Время создания
 * @property int      $UpdatedAt  Время обновления
 * @property int      $DeletedAt  Время удаления
 * @property int      $ClosedAt   Заказ закончен
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Customer', 'State', 'CreatedAt', 'UpdatedAt', 'DeletedAt', 'ClosedAt'], 'integer'],
            [['Delivery'], 'safe'],
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
            'Id'        => Yii::t('app', 'Идентификатор записи'),
            'Number'    => Yii::t('app', 'Номер заказа'),
            'Customer'  => Yii::t('app', 'Заказчик'),
            'Delivery'  => Yii::t('app', 'Информация о доставке'),
            'State'     => Yii::t('app', 'Состояние заказа'),
            'Sum'       => Yii::t('app', 'Сумма заказа'),
            'CreatedAt' => Yii::t('app', 'Время создания'),
            'UpdatedAt' => Yii::t('app', 'Время обновления'),
            'DeletedAt' => Yii::t('app', 'Время удаления'),
            'ClosedAt'  => Yii::t('app', 'Заказ закончен'),
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
     * {@inheritdoc}
     * @return CustomerOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerOrderQuery(get_called_class());
    }
}
