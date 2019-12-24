<?php

namespace common\models;

use sjaakp\spatial\ActiveQuery;

/**
 * This is the ActiveQuery class for [[CustomerOrder]].
 *
 * @see CustomerOrder
 */
class CustomerOrderQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CustomerOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CustomerOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
