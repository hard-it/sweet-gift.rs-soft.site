<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Keyword".
 *
 * @property string $Name Наименование
 */
class Keyword extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Keyword';
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
     * @return KeywordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KeywordQuery(get_called_class());
    }
}
