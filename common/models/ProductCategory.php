<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "ProductCategory".
 *
 * @property int    $Id          Идентификатор записи
 * @property string $Code        Код категории
 * @property string $Name        Наименование
 * @property string $Description Описание
 */
class ProductCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ProductCategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Description'], 'string'],
            [['Code'], 'string', 'max' => 10],
            [['Name'], 'string', 'max' => 128],
            [['Code'], 'unique'],
            [['Name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id'          => Yii::t('app', 'Идентификатор записи'),
            'Code'        => Yii::t('app', 'Код категории'),
            'Name'        => Yii::t('app', 'Наименование'),
            'Description' => Yii::t('app', 'Описание'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::class, ['Category' => 'Id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['ProductCategory' => 'Id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductCategoryQuery(get_called_class());
    }
}
