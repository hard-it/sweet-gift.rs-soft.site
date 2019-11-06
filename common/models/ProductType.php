<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ProductType".
 *
 * @property int      $Id               Идентификатор записи
 * @property int      $Category         Категория товара
 * @property Category $сategory0        Категория товара
 * @property string   $Code             Код
 * @property string   $Name             Наименование
 * @property int      $MinimalQuantity  Минимальное количество
 * @property int      $ShelfLife        Срок хранения, сек
 * @property int      $Measure          Единица измерения
 * @property string   $Cost             Цена за единицу
 * @property string   $Description      Описание
 * @property array    $Tags             Тэги
 * @property array    $Keywords         Ключевые слова
 * @property array    $Images           Изображения
 */
class ProductType extends ActiveRecord
{

    const MEASURE_VALUES = [
        1     => 'сек',
        60    => 'мин',
        3600  => 'час',
        86400 => 'суток',

    ];

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
            [['Measure'], 'default', 'value' => 3600],
            [['Cost'], 'number'],
            [['Description'], 'string'],
            [['Code'], 'string', 'max' => 21],
            [['Name'], 'string', 'max' => 128],
            [['Code'], 'required'],
            [['Name'], 'required'],
            [['Tags', 'Keywords', 'Images'], 'safe'],
            [['Category', 'Code'], 'unique', 'targetAttribute' => ['Category', 'Code']],
            [['Category', 'Name'], 'unique', 'targetAttribute' => ['Category', 'Name']],
            [['Category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::class, 'targetAttribute' => ['Category' => 'Id']],
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
            'Cost'            => Yii::t('app', 'Цена за единицу'),
            'Description'     => Yii::t('app', 'Описание'),
            'Tags'            => Yii::t('app', 'Тэги'),
            'Keywords'        => Yii::t('app', 'Ключевые слова'),
            'Images'          => Yii::t('app', 'Изображения'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(ProductCategory::class, ['Id' => 'Category']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['ProductType' => 'Id']);
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
