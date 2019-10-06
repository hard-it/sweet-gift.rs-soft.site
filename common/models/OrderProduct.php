<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "OrderProduct".
 *
 * @property int    $Id            Идентификатор записи
 * @property int    $CustomerOrder Заказ
 * @property int    $Product       Продукт
 * @property int    $Quantity      Количество
 * @property string $Cost          Стоимость
 * @property string $Comment       Примечание
 */
class OrderProduct extends \yii\db\ActiveRecord
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
            [['Cost'], 'number'],
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
            'Comment'       => Yii::t('app', 'Примечание'),
        ];
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
