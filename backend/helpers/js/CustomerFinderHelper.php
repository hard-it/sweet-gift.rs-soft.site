<?php

namespace backend\helpers\js;

class CustomerFinderHelper extends BaseJsHelper
{

    public static function buildFinderScript(string $fieldId, string $customerId, string $firstNameId, string $lastNameId)
    {
        $js = <<<JS
          $("#{$fieldId}").on('change', function() {
            let data = {
            phone: $('#{$fieldId}').val()              
          };
            $.ajax({
              url: '/customer/find-by-phone',
            data: data,
            }).done(function (data) {

              $('#{$customerId}').removeAttr('value');

              if (!data.code) {
                $('#{$customerId}').val(data.data.Id);
                $('#{$fieldId}').val(data.data.Phone);
                $('#{$firstNameId}').val(data.data.Firstname);
                $('#{$lastNameId}').val(data.data.Lastname);
              } else {
                $('#{$customerId}').removeAttr('value');
                $('#{$firstNameId}').removeAttr('value');
                $('#{$lastNameId}').removeAttr('value');
              }
            });
          });
JS;
        return $js;
    }
}
