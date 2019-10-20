<?php

namespace backend\helpers\js;

use yii\web\View;

/**
 * Class MultiInputHelper
 * @package backend\helpers\js
 */
class MultiInputHelper
{
    /**
     * @param View   $view
     * @param string $inputId
     */
    public static function registerImageScript(View $view, string $inputId)
    {
        $js = <<<JS
$("#{$inputId}").on('afterInit', function() {
    $("#{$inputId} input").on('input change', reloadImage);
}).on('afterAddRow', function(e, row, currentIndex) {
  row.find("input:first").on('input change', reloadImage);
  row.find("img:first").tooltip();
});
JS;

        static::registerUpdateImageScript($view);
        $view->registerJs($js);
    }

    public static function registerTooltip(View $view)
    {
        $js = <<<JS
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
})
JS;
        $view->registerJs($js);
    }

    /**
     * @param View $view
     */
    protected static function registerUpdateImageScript(View $view)
    {
        $js = <<<JS
        function reloadImage() {
         let img = $(this).closest('tr').find('img:first');
         img.attr('src',$(this).val());
         let tooltip ="<img src='"+$(this).val()+"' height='400'>";
         img.attr('title',tooltip).tooltip('fixTitle');
        }
JS;
        $view->registerJs($js);
    }
}