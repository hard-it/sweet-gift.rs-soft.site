<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "authrule".
 *
 * @property string $name       Наименование
 * @property resource $data     Данные
 * @property int $created_at    Создано
 * @property int $updated_at    Изменено
 *
 * @property Authitem[] $authitems
 */
class AuthRule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'AuthRule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Наименование'),
            'data' => Yii::t('app', 'Данные'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Изменено'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthitems()
    {
        return $this->hasMany(AuthItem::className(), ['rule_name' => 'name']);
    }
}
