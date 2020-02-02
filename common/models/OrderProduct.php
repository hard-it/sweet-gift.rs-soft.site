<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "OrderProduct".
 *
 * @property int           $Id             Идентификатор записи
 * @property int           $CustomerOrder  Заказ
 * @property CustomerOrder $сustomerOrder0 Заказ
 * @property int           $Product        Продукт
 * @property int           $Quantity       Количество
 * @property number        $Cost           Стоимость
 * @property string        $Comment        Примечание
 * @property number        $Sum            Сумма
 */
class OrderProduct extends ActiveQuery
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'OrderProduct';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CustomerOrder', 'Product', 'Quantity'], 'integer'],
            [['Cost', 'Sum'], 'number'],
            [['Comment'], 'string'],
            [['CustomerOrder'], 'exist', 'skipOnError' => true, 'targetClass' => Customerorder::className(), 'targetAttribute' => ['CustomerOrder' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id'            => Yii::t('app', 'Идентификатор записи'),
            'CustomerOrder' => Yii::t('app', 'Заказ'),
            'Product'       => Yii::t('app', 'Продукт'),
            'Quantity'      => Yii::t('app', 'Количество'),
            'Cost'          => Yii::t('app', 'Стоимость'),
            'Sum'           => Yii::t('app', 'Сумма'),
            'Comment'       => Yii::t('app', 'Примечание'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomerOrder0()
    {
        return $this->hasOne(CustomerOrder::class, ['Id' => 'CustomerOrder']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductParts()
    {
        return $this->hasMany(ProductPart::class, ['Product' => 'Id']);
    }

    /**
     * {@inheritdoc}
     * @return OrderProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderProductQuery(get_called_class());
    }
}
