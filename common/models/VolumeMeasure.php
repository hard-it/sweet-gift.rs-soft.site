<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "volumemeasure".
 *
 * @property int           $Id        Идентификатор записи
 * @property string|null   $ShortName Сокращение
 * @property string|null   $OneName   Один
 * @property string|null   $SomeName  Несколько
 * @property string|null $ManyName      Много
 *
 * @property ProductType[] $productTypes
 */
class VolumeMeasure extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'VolumeMeasure';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ShortName'], 'string', 'max' => 20],
            [['OneName', 'SomeName', 'ManyName'], 'string', 'max' => 64],
            [['ShortName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id'        => Yii::t('app', 'Идентификатор записи'),
            'ShortName' => Yii::t('app', 'Сокращение'),
            'OneName'   => Yii::t('app', 'Один'),
            'SomeName'  => Yii::t('app', 'Пара'),
            'ManyName'      => Yii::t('app', 'Много'),
        ];
    }

    /**
     * Gets query for [[Producttypes]].
     *
     * @return \yii\db\ActiveQuery|ProductTypeQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(Producttype::class, ['VolumeSizeMeasure' => 'Id']);
    }

    /**
     * {@inheritdoc}
     * @return VolumeMeasureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VolumeMeasureQuery(get_called_class());
    }
    /**
     * @return array
     */
    public static function getList()
    {
        $list = static::find()->orderBy(['ShortName' => 'ASC'])->all();

        $dataList = ArrayHelper::map($list, 'Id', 'ShortName');

        return $dataList;

    }
}
