<?php

namespace backend\helpers\js;

use Yii;
use webtoucher\cookie\AssetBundle;

/**
 * Class TimeZoneHelper
 * @package backend\helpers\js
 */
class TimeZoneHelper extends BaseJsHelper
{
    /**
     * @param string $cookieName
     *
     * @return \DateTimeZone|null
     */
    public static function getTimeZone(string $cookieName)
    {
        $cookies = Yii::$app->request->cookies;

        $zoneMinutes = $cookies->get($cookieName) ?? 0;

        $timezoneName = timezone_name_from_abbr("", $zoneMinutes * 60, false);

        $timeZone = null;

        if ($timezoneName !== false) {
            $timeZone = new \DateTimeZone($timezoneName);
        }

        return $timeZone;
    }

    /**
     * @param string $cookieName
     * @param string $time
     * @param string $format
     *
     * @return int
     */
    public static function parseTime(string $cookieName, string $time, string $format, bool $clientZone = false)
    {
        $timeZone = null;

        if ($clientZone) {
            $timeZone = static::getTimeZone($cookieName);
        }

        $dt = \DateTime::createFromFormat($format, $time, $timeZone);

        return $dt->getTimestamp();
    }

    /**
     * @param string $cookieName
     * @param int    $time
     * @param string $format
     *
     * @return string
     * @throws \Exception
     */
    public static function buildTime(string $cookieName, int $time, string $format)
    {
        $timeZone = static::getTimeZone($cookieName);

        $dt = new \DateTime('now', $timeZone);

        $dt->setTimestamp($time);

        return $dt->format($format);

    }

    /**
     * @param string $formId
     * @param string $cookieName
     */
    public function registerZimeZoneSender(string $formId, string $cookieName)
    {
        AssetBundle::register($this->view);
        $js = "
            $('#{$formId}').submit(function(event) {

                event.preventDefault();
                let timezoneOffsetMinutes = new Date().getTimezoneOffset();
                timezoneOffsetMinutes = timezoneOffsetMinutes == 0 ? 0 : -timezoneOffsetMinutes;
                Cookie.set('{$cookieName}', timezoneOffsetMinutes);
                $(this).unbind('submit').submit();
            });
        ";

        $this->view->registerJs($js);
    }

}
