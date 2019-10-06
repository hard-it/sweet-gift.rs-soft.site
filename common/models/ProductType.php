<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ProductType".
 *
 * @property int    $Id              Идентификатор записи
 * @property int    $Category        Категория товара
 * @property string $Code            Код
 * @property string $Name            Наименование
 * @property int    $MinimalQuantity Минимальное количество
 * @property int    $ShelfLife       Срок хранения, сек
 * @property int    $Measure         Единица измерения
 * @property string $Cost            Цена
 * @property string $Description     Описание
 */
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ProductType';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Category', 'MinimalQuantity', 'ShelfLife', 'Measure'], 'integer'],
            [['Cost'], 'number'],
            [['Description'], 'string'],
            [['Code'], 'string', 'max' => 21],
            [['Name'], 'string', 'max' => 128],
            [['Category', 'Code'], 'unique', 'targetAttribute' => ['Category', 'Code']],
            [['Category', 'Name'], 'unique', 'targetAttribute' => ['Category', 'Name']],
            [['Category'], 'exist', 'skipOnError' => true, 'targetClass' => Productcategory::className(), 'targetAttribute' => ['Category' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id'              => Yii::t('app', 'Идентификатор записи'),
            'Category'        => Yii::t('app', 'Категория товара'),
            'Code'            => Yii::t('app', 'Код'),
            'Name'            => Yii::t('app', 'Наименование'),
            'MinimalQuantity' => Yii::t('app', 'Минимальное количество'),
            'ShelfLife'       => Yii::t('app', 'Срок хранения, сек'),
            'Measure'         => Yii::t('app', 'Единица измерения'),
            'Cost'            => Yii::t('app', 'Цена'),
            'Description'     => Yii::t('app', 'Описание'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProductTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductTypeQuery(get_called_class());
    }
}
