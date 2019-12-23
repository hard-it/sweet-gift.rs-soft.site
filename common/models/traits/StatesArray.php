<?php


namespace common\models\traits;


trait StatesArray
{
    /**
     * @param $offset
     * @param $value
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->states[] = $value;
        } else {
            $this->states[$offset] = $value;
        }
    }

    /**
     * @param $offset
     *
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->states[$offset]);
    }

    /**
     * @param $offset
     */
    public function offsetUnset($offset) {
        unset($this->states[$offset]);
    }

    /**
     * @param $offset
     *
     * @return |null
     */
    public function offsetGet($offset) {
        return isset($this->states[$offset]) ? $this->states[$offset] : null;
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
}