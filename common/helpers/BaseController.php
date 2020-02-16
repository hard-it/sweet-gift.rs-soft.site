<?php

namespace common\helpers;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    const JSON_CODE_FIELD    = 'code';
    const JSON_MESSAGE_FIELD = 'message';
    const JSON_DATA_FIELD    = 'data';

    const CODE_OK    = 0;
    const MESSAGE_OK = 'OK';

    const CODE_NOT_FOUND    = 404;
    const MESSAGE_NOT_FOUND = 'Item not found';

    /**
     * @param int    $code
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function buildJsonAnswer(int $code = self::CODE_OK, string $message = self::MESSAGE_OK, $data = [])
    {
        return [
            static::JSON_CODE_FIELD    => $code,
            static::JSON_MESSAGE_FIELD => $message,
            static::JSON_DATA_FIELD    => $data,
        ];
    }

    /**
     * @return array
     */
    public static function buildNotFoundAnswer()
    {
        return static::buildJsonAnswer(
            static::CODE_NOT_FOUND,
            Yii::t('app', static::MESSAGE_NOT_FOUND)
        );
    }
}
