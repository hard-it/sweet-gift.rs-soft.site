<?php


namespace common\models;


use yii\db\ActiveRecord;

/**
 * Class BaseActiveRecord
 * @package common\models
 */

class BaseActiveRecord extends ActiveRecord
{

    const NO_ERROR_CODE    = 0;
    const NO_ERROR_MESSAGE = 'Ok';

    const SERVER_ERROR_CODE    = 2;
    const SERVER_ERROR_MESSAGE = 'Database access error. Please, try later.';


    const ERROR_MESSAGES = [
        self::SERVER_ERROR_CODE => self::SERVER_ERROR_MESSAGE,
        self::NO_ERROR_CODE     => self::NO_ERROR_MESSAGE,
    ];


}