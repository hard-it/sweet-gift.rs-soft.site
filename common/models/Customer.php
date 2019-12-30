<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;

/**
 * This is the model class for table "Customer".
 *
 * @property int    $Id         Идентификатор записи
 * @property string $Phone      Телефон
 * @property string $Firstname  Имя
 * @property string $Lastname   Фамилия
 * @property int    $User       Пользователь
 * @property User   $user0      Пользователь
 */
class Customer extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['User'], 'integer'],
            [['Phone'], 'string', 'max' => 20],
            [['Firstname', 'Lastname'], 'string', 'max' => 64],
            [['Phone'], 'unique'],
            [['Phone'], 'string'],
            [['Phone'], PhoneInputValidator::class],
            [['User'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['User' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id'        => Yii::t('app', 'Идентификатор записи'),
            'Phone'     => Yii::t('app', 'Телефон'),
            'Firstname' => Yii::t('app', 'Имя'),
            'Lastname'  => Yii::t('app', 'Фамилия'),
            'User'      => Yii::t('app', 'Пользователь'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomerOrders()
    {
        return $this->hasMany(CustomerOrder::class, ['Customer' => 'Id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::class, ['Id' => 'User']);
    }

    /**
     * {@inheritdoc}
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}
