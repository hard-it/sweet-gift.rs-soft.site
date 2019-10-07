<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "ProductPart".
 *
 * @property int          $Id             Идентификатор записи
 * @property int          $OrderProduct   Продукт заказа
 * @property OrderProduct $orderProduct0  Продукт заказа
 * @property int          $Product        Произведённый продукт
 * @property Product      $product0       Произведённый продукт
 * @property int          $Quantity       Количество
 * @property array        $State          Состояние части продукта
 */
class ProductPart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ProductPart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OrderProduct', 'Product', 'Quantity'], 'integer'],
            [['State'], 'safe'],
            [['OrderProduct'], 'exist', 'skipOnError' => true, 'targetClass' => Orderproduct::className(), 'targetAttribute' => ['OrderProduct' => 'Id']],
            [['Product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['Product' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id'           => Yii::t('app', 'Идентификатор записи'),
            'OrderProduct' => Yii::t('app', 'Продукт заказа'),
            'Product'      => Yii::t('app', 'Произведённый продукт'),
            'Quantity'     => Yii::t('app', 'Количество'),
            'State'        => Yii::t('app', 'Состояние части продукта'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getOrderProduct0()
    {
        return $this->hasOne(OrderProduct::class, ['Id' => 'OrderProduct']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(Product::class, ['Id' => 'Product']);
    }

    /**
     * {@inheritdoc}
     * @return ProductPartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductPartQuery(get_called_class());
    }
}
