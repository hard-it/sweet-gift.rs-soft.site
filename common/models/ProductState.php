<?php

namespace common\models;

/**
 * Class ProductState
 * @package common\models
 */
class ProductState
{
    const PRODUCT_STATE_ABSENT    = 0;
    const PRODUCT_STATE_IN_ORDER  = 1;
    const PRODUCT_STATE_MAKING    = 2;
    const PRODUCT_STATE_MADE      = 3;
    const PRODUCT_STATE_PACKED    = 4;
    const PRODUCT_STATE_DELIVERY  = 5;
    const PRODUCT_STATE_HANDED    = 6;
    const PRODUCT_STATE_CANCELLED = 7;

    const PRODUCT_FIELD_STATE       = 'state';
    const PRODUCT_FIELD_AT          = 'at';
    const PRODUCT_FIELD_DESCRIPTION = 'description';

    protected $state = self::PRODUCT_STATE_ABSENT;

    protected $at;

    protected $description;

    /**
     * ProductState constructor.
     *
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $this->state       = $data[static::PRODUCT_FIELD_STATE] ?? static::PRODUCT_STATE_ABSENT;
        $this->at          = $data[static::PRODUCT_FIELD_AT] ?? time();
        $this->description = $data[static::PRODUCT_FIELD_DESCRIPTION] ?? '';
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [
            static::PRODUCT_FIELD_STATE       => $this->state ?? static::PRODUCT_STATE_ABSENT,
            static::PRODUCT_FIELD_AT          => $this->at ?? static::PRODUCT_FIELD_AT,
            static::PRODUCT_FIELD_DESCRIPTION => $this->description ?? '',
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
}
