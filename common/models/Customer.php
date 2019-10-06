<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Customer".
 *
 * @property int    $Id        Идентификатор записи
 * @property string $Phone     Телефон
 * @property string $Firstname Имя
 * @property string $Lastname  Фамилия
 * @property int    $User      Пользователь
 */
class Customer extends \yii\db\ActiveRecord
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
            [['User'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['User' => 'id']],
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
     * {@inheritdoc}
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}
