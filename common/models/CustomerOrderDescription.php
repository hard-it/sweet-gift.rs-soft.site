<?php

namespace common\models;

use yii\base\Model;

/**
 * Class CustomerOrderDescription
 * @package common\models
 */
class CustomerOrderDescription extends Model
{
    const CUSTOMER_ORDER_FIELD_CUSTOMER_ID = 'customerId';
    const CUSTOMER_ORDER_FIELD_AT          = 'at';
    const CUSTOMER_ORDER_FIELD_PHONE       = 'phone';
    const CUSTOMER_ORDER_FIELD_FIRSTNAME   = 'firstname';
    const CUSTOMER_ORDER_FIELD_LASTNAME    = 'lastname';
    const CUSTOMER_ORDER_FIELD_CITY        = 'city';
    const CUSTOMER_ORDER_FIELD_DISTRICT    = 'district';
    const CUSTOMER_ORDER_FIELD_STREET      = 'street';
    const CUSTOMER_ORDER_FIELD_HOUSE       = 'house';
    const CUSTOMER_ORDER_FIELD_HOUSING     = 'housing';
    const CUSTOMER_ORDER_FIELD_PORCH       = 'porch';
    const CUSTOMER_ORDER_FIELD_LEVEL       = 'level';
    const CUSTOMER_ORDER_FIELD_APP         = 'app';
    const CUSTOMER_ORDER_FIELD_ROOM        = 'room';
    const CUSTOMER_ORDER_FIELD_DESCRIPTION = 'description';

    public $customerId;

    public $at;

    public $phone;

    public $firstname;

    public $lastname;

    public $city;

    public $district;

    public $street;

    public $house;

    public $housing;

    public $porch;

    public $level;

    public $app;

    public $room;

    public $description;


    /**
     * CustomerOrderDescription constructor.
     *
     * @param array|null $data
     */

    public function __construct($config = [], array $data = null)
    {
        parent::__construct($config);

        $this->customerId  = $data[static::CUSTOMER_ORDER_FIELD_CUSTOMER_ID] ?? null;
        $this->at          = $data[static::CUSTOMER_ORDER_FIELD_AT] ?? time();
        $this->phone       = $data[static::CUSTOMER_ORDER_FIELD_PHONE] ?? '';
        $this->firstname   = $data[static::CUSTOMER_ORDER_FIELD_FIRSTNAME] ?? '';
        $this->lastname    = $data[static::CUSTOMER_ORDER_FIELD_LASTNAME] ?? '';
        $this->city        = $data[static::CUSTOMER_ORDER_FIELD_CITY] ?? '';
        $this->district    = $data[static::CUSTOMER_ORDER_FIELD_DISTRICT] ?? '';
        $this->street      = $data[static::CUSTOMER_ORDER_FIELD_STREET] ?? '';
        $this->house       = $data[static::CUSTOMER_ORDER_FIELD_HOUSE] ?? '';
        $this->housing     = $data[static::CUSTOMER_ORDER_FIELD_HOUSING] ?? '';
        $this->porch       = $data[static::CUSTOMER_ORDER_FIELD_PORCH] ?? '';
        $this->level       = $data[static::CUSTOMER_ORDER_FIELD_LEVEL] ?? '';
        $this->app         = $data[static::CUSTOMER_ORDER_FIELD_APP] ?? '';
        $this->room        = $data[static::CUSTOMER_ORDER_FIELD_ROOM] ?? '';
        $this->description = $data[static::CUSTOMER_ORDER_FIELD_DESCRIPTION] ?? '';
    }
}
