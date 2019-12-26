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
     */
    public static function setTimezone(string $cookieName)
    {
        $cookies = Yii::$app->request->cookies;

        $zoneMinutes = $cookies->get($cookieName) ?? 0;

        $timezoneName = timezone_name_from_abbr("", $zoneMinutes*60, false);

        date_default_timezone_set($timezoneName);
    }

    /**
     * @param string $formId
     * @param string $cookieName
     */
    public function registerZimezoneSender(string $formId, string $cookieName)
    {
        AssetBundle::register($this->view);
        $js ="
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
