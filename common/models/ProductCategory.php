<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "ProductCategory".
 *
 * @property int    $Id            Идентификатор записи
 * @property string $Code          Код категории
 * @property string $Name          Наименование
 * @property string $Description   Описание
 * @property int    $root          Tree root identifier
 * @property int    $lft           Nested set left property
 * @property int    $rgt           Nested set right property
 * @property int    $lvl           Nested set level / depth
 * @property string $icon          The icon to use for the node
 * @property int    $icon_type     Icon Type: 1 = CSS Class, 2 = Raw Markup
 * @property int    $active        Whether the node is active (will be set to false on deletion)
 * @property int    $selected      Whether the node is selected/checked by default
 * @property int    $disabled      Whether the node is enabled
 * @property int    $readonly      Whether the node is read only (unlike disabled - will allow toolbar actions)
 * @property int    $visible       Whether the node is visible
 * @property int    $collapsed     Whether the node is collapsed by default
 * @property int    $movable_u     Whether the node is movable one position up
 * @property int    $movable_d     Whether the node is movable one position down
 * @property int    $movable_l     Whether the node is movable to the left (from sibling to parent)
 * @property int    $movable_r     Whether the node is movable to the right (from sibling to child)
 * @property int    $removable     Whether the node is removable (any children below will be moved as siblings before deletion)
 * @property int    $removable_all Whether the node is removable along with descendants
 * @property int    $child_allowed Whether to allow adding children to the node
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
            [['icon'], 'string', 'max' => 255],
            [['Code'], 'unique'],
            [['Name'], 'unique'],
            [['table_id', 'root', 'lft', 'rgt', 'lvl', 'icon_type', 'active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all', 'child_allowed'], 'integer'],
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
            'root'          => Yii::t('app', 'Tree root identifier'),
            'lft'           => Yii::t('app', 'Nested set left property'),
            'rgt'           => Yii::t('app', 'Nested set right property'),
            'lvl'           => Yii::t('app', 'Nested set level / depth'),
            'icon'          => Yii::t('app', 'The icon to use for the node'),
            'icon_type'     => Yii::t('app', 'Icon Type: 1 = CSS Class, 2 = Raw Markup'),
            'active'        => Yii::t('app', 'Whether the node is active (will be set to false on deletion)'),
            'selected'      => Yii::t('app', 'Whether the node is selected/checked by default'),
            'disabled'      => Yii::t('app', 'Whether the node is enabled'),
            'readonly'      => Yii::t('app', 'Whether the node is read only (unlike disabled - will allow toolbar actions)'),
            'visible'       => Yii::t('app', 'Whether the node is visible'),
            'collapsed'     => Yii::t('app', 'Whether the node is collapsed by default'),
            'movable_u'     => Yii::t('app', 'Whether the node is movable one position up'),
            'movable_d'     => Yii::t('app', 'Whether the node is movable one position down'),
            'movable_l'     => Yii::t('app', 'Whether the node is movable to the left (from sibling to parent)'),
            'movable_r'     => Yii::t('app', 'Whether the node is movable to the right (from sibling to child)'),
            'removable'     => Yii::t('app', 'Whether the node is removable (any children below will be moved as siblings before deletion)'),
            'removable_all' => Yii::t('app', 'Whether the node is removable along with descendants'),
            'child_allowed' => Yii::t('app', 'Whether to allow adding children to the node'),

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
