<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use kartik\tree\models\Tree;

/**
 * This is the model class for table "ProductCategory".
 *
 * @property int    $Id              Идентификатор записи
 * @property string $Code            Код категории
 * @property string $Name            Наименование
 * @property string $Description     Описание
 * @property array  $Tags            Тэги
 * @property array  $Images          Изображения
 * @property array  $Keywords        Ключевые слова
 * @property int    $root            Tree root identifier
 * @property int    $lft             Nested set left property
 * @property int    $rgt             Nested set right property
 * @property int    $lvl             Nested set level / depth
 * @property string $icon            The icon to use for the node
 * @property int    $icon_type       Icon Type: 1 = CSS Class, 2 = Raw Markup
 * @property int    $active          Whether the node is active (will be set to false on deletion)
 * @property int    $selected        Whether the node is selected/checked by default
 * @property int    $disabled        Whether the node is enabled
 * @property int    $readonly        Whether the node is read only (unlike disabled - will allow toolbar actions)
 * @property int    $visible         Whether the node is visible
 * @property int    $collapsed       Whether the node is collapsed by default
 * @property int    $movable_u       Whether the node is movable one position up
 * @property int    $movable_d       Whether the node is movable one position down
 * @property int    $movable_l       Whether the node is movable to the left (from sibling to parent)
 * @property int    $movable_r       Whether the node is movable to the right (from sibling to child)
 * @property int    $removable       Whether the node is removable (any children below will be moved as siblings before deletion)
 * @property int    $removable_all   Whether the node is removable along with descendants
 * @property int    $child_allowed   Whether to allow adding children to the node
 */
class ProductCategory extends Tree
{
    const DEFAULT_IMAGE = '/images/water-mark.png';

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
            [['icon'], 'string', 'max' => 255],
            [['Code'], 'unique'],
            [['Code'], 'required'],
            [['Name'], 'unique'],
            [['Name'], 'required'],
            [['Tags', 'Keywords', 'Images'], 'safe'],
            [['root', 'lft', 'rgt', 'lvl', 'icon_type', 'active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all', 'child_allowed'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id'            => Yii::t('app', 'Идентификатор записи'),
            'Code'          => Yii::t('app', 'Код категории'),
            'Name'          => Yii::t('app', 'Наименование'),
            'Description'   => Yii::t('app', 'Описание'),
            'Tags'          => Yii::t('app', 'Тэги'),
            'Keywords'      => Yii::t('app', 'Ключевые слова'),
            'Images'        => Yii::t('app', 'Изображения для категории товаров'),
            'root'          => Yii::t('app', 'Идентификатор корня дерева'),
            'lft'           => Yii::t('app', 'Связь слева'),
            'rgt'           => Yii::t('app', 'Связь справа'),
            'lvl'           => Yii::t('app', 'Уровень вложенности'),
            'icon'          => Yii::t('app', 'Используемая иконка'),
            'icon_type'     => Yii::t('app', 'Тип иконки'),
            'active'        => Yii::t('app', 'Узел активен'),
            'selected'      => Yii::t('app', 'Узел выбран'),
            'disabled'      => Yii::t('app', 'Узел отключён'),
            'readonly'      => Yii::t('app', 'Узел только для чтения'),
            'visible'       => Yii::t('app', 'Узел видим'),
            'collapsed'     => Yii::t('app', 'Узел свёрнут по- умолчанию'),
            'movable_u'     => Yii::t('app', 'Можно перемещать вверх на шаг'),
            'movable_d'     => Yii::t('app', 'Можно перемещать вниз на шаг'),
            'movable_l'     => Yii::t('app', 'Можно переместить к родителю'),
            'movable_r'     => Yii::t('app', 'Можно переместить к подчинённому'),
            'removable'     => Yii::t('app', 'Можно удалять с перемещением подчинённых'),
            'removable_all' => Yii::t('app', 'Можно удалять с подчинёнными'),
            'child_allowed' => Yii::t('app', 'Можно добавлять подчинённые'),

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
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        $images    = $this->Images ?? [];
        $tmpImages = [];
        foreach ($images as $key => $image) {
            $tmpImages[$image['order'] ?? $key] = $image;
        }
        $this->Images = $tmpImages;

        return parent::beforeSave($insert);
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
