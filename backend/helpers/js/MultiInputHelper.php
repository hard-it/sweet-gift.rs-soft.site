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

    public static function registerInsertDateTimeValue(View $view, string $controlId, string $selector)
    {
        MomentAssetBundle::register($view);

        $js = <<<JS
        $('#{$controlId}').on('afterAddRow', function(event, row, currentIndex) {
          let dt = new Date();
            console.log(moment(dt).format('DD.MM.YYYY HH:mm'));
            $(row).find('$selector').val(moment(dt).format('DD.MM.YYYY HH:mm'));
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

    public static function buildAfterSelectOrderProductCost()
    {
        $js = <<<JS

        function loadOrderProductCost(point) {
          let blockDiv = $(point).parent().parent().parent().parent();
          let productId = $(point).val();
          let productCost = blockDiv.find('.product-cost');
          let productQty = blockDiv.find('.product-quantity');
          let productSum = blockDiv.find('.product-sum');
          
          let data = {
            id: productId              
          };
            $.ajax({
              url: '/product-type/cost',
            data: data,
            }
            ).done(function (data) {

              console.log(blockDiv.html());
              console.log(productCost.html());
              
            if (data.code) {
              data.data.cost = 0.00;
            }
            productCost.val(data.data.cost);
            productSum.val(data.data.cost * productQty.val());
            $('#pay-error').html('&nbsp;')
        } ).fail(function () {
        $('#pay-error').html(anyThingMessage);
      });
      };
JS;

        return $js;

    }

    /**
     * @param string $valueContainer
     * @param int    $decimals
     *
     * @return string
     */
    public static function addFormatMoneyValue(string $valueContainer, int $decimals)
    {
        $js = <<<JS
        $('{$valueContainer}').on('change input keyup', function () {
          
        });
JS;

        return $js;

    }
}
