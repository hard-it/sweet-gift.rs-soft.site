<?php

namespace common\models;

use Yii;

/**
 * Class CustomerOrderState
 * @package common\models
 */
class CustomerOrderState
{
    const ORDER_STATE_ALL      = -1;
    const ORDER_STATE_CREATED  = 0;
    const ORDER_STATE_MAKING   = 2;
    const ORDER_STATE_MADE     = 3;
    const ORDER_STATE_PACKED   = 4;
    const ORDER_STATE_DELIVERY = 5;
    const ORDER_STATE_HANDED   = 6;
    const ORDER_STATE_CANCELED = 7;

    const ORDER_FIELD_STATE       = 'state';
    const ORDER_FIELD_AT          = 'at';
    const ORDER_FIELD_DESCRIPTION = 'description';

    protected $state = self::ORDER_STATE_CREATED;

    protected $at;

    protected $description;

    /**
     * ProductState constructor.
     *
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $this->state       = $data[static::ORDER_FIELD_STATE] ?? static::ORDER_STATE_CREATED;
        $this->at          = $data[static::ORDER_FIELD_AT] ?? time();
        $this->description = $data[static::ORDER_FIELD_DESCRIPTION] ?? '';
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [
            static::ORDER_FIELD_STATE       => $this->state ?? static::ORDER_STATE_CREATED,
            static::ORDER_FIELD_AT          => $this->at ?? time(),
            static::ORDER_FIELD_DESCRIPTION => $this->description ?? '',
        ];

        return $result;
    }

    /**
     * @return int|mixed
     */
    public function getAt()
    {
        return $this->at;
    }

    /**
     * @return mixed|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $at
     *
     * @return $this
     */
    public function setAt($at)
    {
        $this->at = $at;

        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return array
     */
    public static function getStatesList()
    {
        return [
            CustomerOrderState::ORDER_STATE_CREATED  => Yii::t('app', 'Заказан'),
            CustomerOrderState::ORDER_STATE_MAKING   => Yii::t('app', 'Изоготавливается'),
            CustomerOrderState::ORDER_STATE_MADE     => Yii::t('app', 'Сделан'),
            CustomerOrderState::ORDER_STATE_PACKED   => Yii::t('app', 'Упакован'),
            CustomerOrderState::ORDER_STATE_DELIVERY => Yii::t('app', 'В доставке'),
            CustomerOrderState::ORDER_STATE_HANDED   => Yii::t('app', 'Вручён'),
            CustomerOrderState::ORDER_STATE_CANCELED => Yii::t('app', 'Отменён'),
        ];
    }
}
