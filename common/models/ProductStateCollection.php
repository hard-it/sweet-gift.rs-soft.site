<?php

namespace common\models;

use common\models\traits\StatesArray;

/**
 * Class ProductStateCollection
 * @package common\models
 */
class ProductStateCollection
{
    /**
     * @var ProductState[]
     */
    protected $states = [];

    /**
     * ProductStateCollection constructor.
     *
     * @param $states
     */
    public function __construct($states)
    {
        if (is_array($states)) {
            foreach ($states as $state) {
                $this->states[] = new ProductState($state);
            }
        }
    }

    use StatesArray;


    /**
     * @return ProductState[]
     */
    public function getStates(): array
    {
        return $this->states;
    }

    /**
     * @param ProductState[] $states
     *
     * @return $this
     */
    public function setStates(array $states)
    {
        $this->states = $states;

        return $this;
    }

    /**
     * @param ProductState $state
     *
     * @return $this
     */
    public function addState(ProductState $state)
    {
        if (is_array($this->states)) {
            $this->states[] = $state;
        } else {
            $this->states = [$state];
        }

        return $this;
    }

    /**
     * @return ProductState|mixed
     */
    public function getCurrentState()
    {
        if (is_array($this->states) && count($this->states)) {
            return $this->states[count($this->states) - 1];
        }

        return new ProductState();
    }

    /**
     * @return ProductState|mixed
     */
    public function getFirstState()
    {
        if (is_array($this->states) && count($this->states)) {
            return $this->states[0];
        }

        return new ProductState();
    }
}
