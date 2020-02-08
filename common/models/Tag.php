<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "Tag".
 *
 * @property string $Name Наименование
 */
class Tag extends BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Name'], 'string', 'max' => 64],
            [['Name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Name' => Yii::t('app', 'Наименование'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $all = static::find()->orderBy('Name')->all();

        return ArrayHelper::map($all, 'Name', 'Name');
    }
}
