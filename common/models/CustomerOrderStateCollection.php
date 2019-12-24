<?php

namespace common\models;

use common\models\traits\StatesArray;

/**
 * Class CustomerOrderStateCollection
 * @package common\models
 */
class CustomerOrderStateCollection implements \ArrayAccess
{
    /**
     * @var CustomerOrderState[]
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
     * @return CustomerOrderState[]
     */
    public function getStates(): array
    {
        return $this->states;
    }

    /**
     * @param CustomerOrderState[] $states
     *
     * @return $this
     */
    public function setStates(array $states)
    {
        $this->states = $states;

        return $this;
    }

    /**
     * @param CustomerOrder $state
     *
     * @return $this
     */
    public function addState(CustomerOrderState $state)
    {
        if (is_array($this->states)) {
            $this->states[] = $state;
        } else {
            $this->states = [$state];
        }

        return $this;
    }

    /**
     * @return CustomerOrderState
     */
    public function getCurrentState()
    {
        if (is_array($this->states) && count($this->states)) {
            return $this->states[count($this->states) - 1];
        }

        return new CustomerOrderState();
    }

    /**
     * @return CustomerOrderState
     */
    public function getFirstState()
    {
        if (is_array($this->states) && count($this->states)) {
            return $this->states[0];
        }

        return new CustomerOrderState();
    }
}
