<?php

namespace backend\helpers\js;

class CustomerFinderHelper extends BaseJsHelper
{

    const CUSTOMER_FIND_BY_PHONE_URL = '/customer/find-by-phone';

    public static function buildFinderScript(string $fieldId, string $customerId, string $firstNameId, string $lastNameId)
    {
        $url = static::CUSTOMER_FIND_BY_PHONE_URL;
        $js  = "
          $('#{$fieldId}').on('change', function() {
            let curPhone = $('#{$fieldId}').val();
            
            if (curPhone.length < 4) {
                return;
            }
            let data = {
            phone: curPhone              
          };
            $.ajax({
              url: '{$url}',
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
          });";

        return $js;
    }
}
