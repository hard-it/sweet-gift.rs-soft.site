<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductPart]].
 *
 * @see ProductPart
 */
class ProductPartQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductPart[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductPart|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
