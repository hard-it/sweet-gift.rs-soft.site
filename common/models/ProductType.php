<?php

namespace common\models;

use common\models\traits\Images;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
class ProductType extends BaseTagKeywordModel
{

    const DEFAULT_MEASURE_VALUE = 3600;

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

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->Measure = static::DEFAULT_MEASURE_VALUE;
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
            [['Code'], 'required'],
            [['Name'], 'required'],
            [['Category'], 'required'],
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
            'ShelfLife'       => Yii::t('app', 'Срок хранения товара'),
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
     * @return ProductStateCollection
     */
    public function getStateCollection(): ProductStateCollection
    {
        return new ProductStateCollection($this->State);
    }

    /**
     * @param ProductStateCollection $state
     *
     * @return $this
     */
    public function setStateCollection(ProductStateCollection $state)
    {
        $this->State = $state->toArray();

        return $this;
    }

    use Images;

    /**
     * @return array
     */
    public function getCostData()
    {
        return [
            'Id'              => $this->Id,
            'Cost'            => $this->Cost,
            'MinimalQuantity' => $this->MinimalQuantity,
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

    public static function getFullTree()
    {
        $products           = static::find()->orderBy('Category, Name')->all();
        $productsByCategory = [];

        foreach ($products as $product) {
            if (!isset($productsByCategory[$product->Category])) {
                $productsByCategory[$product->Category] = [];
            }

            $productsByCategory[$product->Category][] = $product;
        }

        $results    = [];
        $categories = ProductCategory::getActiveTree();

        static::buildFullTree($results, $categories, $productsByCategory, 0, 0);

        return $results;
    }

    protected static function buildFullTree(array &$root, array $categories, array $products, int $prevLevel, int $curIndex): int
    {
        while ($curIndex < count($categories)) {
            /**
             * @var ProductCategory $category
             */
            $category = $categories[$curIndex];

            if ($category->lvl == $prevLevel) {
                $categoryIndex        = str_repeat('  ', $category->lvl + 1) . $category->Name;
                $root[$categoryIndex] = [];
                $curIndex             = static::buildFullTree($root[$categoryIndex], $categories, $products, $prevLevel + 1, $curIndex + 1);
                if (isset($products[$category->Id])) {
                    $root[$categoryIndex] = ArrayHelper::merge($root[$categoryIndex], ArrayHelper::map($products[$category->Id], 'Id', 'Name'));
                }
                continue;
            }
            if ($category->lvl < $prevLevel) {
                break;
            }
        }

        return $curIndex;
    }
}
