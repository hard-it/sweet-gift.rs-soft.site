<?php


namespace common\helpers;

use yii\web\Controller;


class BaseController extends Controller
{
    const JSON_CODE_FIELD    = 'code';
    const JSON_MESSAGE_FIELD = 'message';
    const JSON_DATA_FIELD    = 'data';

    /**
     * @param int    $code
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function buildJsonAnswer(int $code = 0, string $message = '', $data = [])
    {
        return [
            static::JSON_CODE_FIELD    => $code,
            static::JSON_MESSAGE_FIELD => $message,
            static::JSON_DATA_FIELD    => $data,
        ];
    }
}