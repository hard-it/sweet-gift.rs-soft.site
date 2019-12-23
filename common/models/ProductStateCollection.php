<?php

namespace common\models;

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

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach ($this->states as $state) {
            $result[] = $state->toArray();
        }

        return $result;
    }

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

    public function getCurrentState()
    {
        if (is_array($this->states) && count($this->states)) {
            return $this->states[count($this->states) - 1];
        }

        return new ProductState();
    }
}
