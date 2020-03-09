<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class TanslitActiveRecord
 * @package common\models
 */
class TanslitActiveRecord extends ActiveRecord
{

    /**
     * @property string $Translit        Транслитерация
     * @property string $Name            Наименование
     */

    const DEFAULT_NAME     = 'Name';
    const DEFAULT_TRANSLIT = 'Translit';

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Translit' => Yii::t('app', 'Транслитерация'),
            'Name'     => Yii::t('app', 'Наименование'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Translit'], 'string', 'max' => 128],
            [['Translit'], 'unique'],
            [['Translit'], 'required'],
            [['Name'], 'string', 'max' => 128],
            [['Name'], 'unique'],
            [['Name'], 'required'],
        ];
    }

    protected function translitName()
    {
        $this->translitVar(static::DEFAULT_NAME, static::DEFAULT_TRANSLIT);
    }

    protected function translitVar(string $original, string $translit)
    {
        $tr = \Transliterator::create('Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();');
        $s  = $tr->transliterate($this->$original);
        $s  = preg_replace('/[-\s]+/', '-', $s);

        $this->$translit = trim($s, '-');
    }
}
