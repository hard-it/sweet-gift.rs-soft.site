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
    $("#{$inputId} .hidden-image-name input").on('input change', reloadImage);
}).on('afterAddRow', function(e, row, currentIndex) {
  row.find("input:first").on('input change', reloadImage);
  row.find("img:first").tooltip();
});
JS;

        static::registerUpdateImageScript($view);
        $view->registerJs($js);
    }

    public static function registerInsertDateTimeValue(View $view, string $controlId, string $className)
    {
        $js = <<<JS
        $('#{$controlId}').on('afterAddRow', function(event, row, currentIndex) {
          let dt = new Date();
          
            $(row).find('.$className').val(dt.parse('DD.MM.YYYY HH:mm'));
            console.log("relink !!!");
            console.log(event);
            console.log(row);
});//afterDropRow
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
         let img = $(this).closest('.multiple-input-list__item').find('.list-cell__PreviewImages img:first');
         img.attr('src',$(this).val());
         let tooltip ="<img src='"+$(this).val()+"' height='400' style='min-height:400px'>";
         //img.attr('title',tooltip).tooltip('fixTitle');
        }
JS;
        $view->registerJs($js);
    }

    /**
     * @param View   $view
     * @param string $formId
     * @param string $hiddenClass
     */
    public static function registerUpdateImagesIndexScript(View $view, string $formId, string $hiddenClass)
    {
        $js = <<<JS
      $('#{$formId}').submit( function() {
      $('.{$hiddenClass}').each(function (index) {
        $(this).val(index);
      })
      });
JS;
        $view->registerJs($js);

    }
}
