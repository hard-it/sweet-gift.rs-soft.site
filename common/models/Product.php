<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Product".
 *
 * @property int   $Id              Идентификатор записи
 * @property int   $ProductCategory Категория продукта
 * @property int   $ProductType     Тип продукта
 * @property int   $Quantity        Количество
 * @property array $State           Множество состояний продукта в JSON.
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProductCategory', 'ProductType', 'Quantity'], 'integer'],
            [['State'], 'safe'],
            [['ProductCategory'], 'exist', 'skipOnError' => true, 'targetClass' => Productcategory::className(), 'targetAttribute' => ['ProductCategory' => 'Id']],
            [['ProductType'], 'exist', 'skipOnError' => true, 'targetClass' => Producttype::className(), 'targetAttribute' => ['ProductType' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id'              => Yii::t('app', 'Идентификатор записи'),
            'ProductCategory' => Yii::t('app', 'Категория продукта'),
            'ProductType'     => Yii::t('app', 'Тип продукта'),
            'Quantity'        => Yii::t('app', 'Количество'),
            'State'           => Yii::t('app', 'Множество состояний продукта в JSON.'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
