<?php

namespace backend\helpers\js\forms;

use backend\helpers\js\BaseJsHelper;
use yii\web\JsExpression;
use yii\helpers\Url;

/**
 * Class ButtonHelper
 * @package backend\helpers\js\forms
 */
class ButtonHelper extends BaseJsHelper
{

    /**
     * @param string $inputClass
     * @param string $buttonClass
     */
    public function registerClearInputTextValue(string $inputClass, string $buttonClass)
    {
        $js = new JsExpression("
                $('.{$buttonClass}').on('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $('.{$inputClass}').val('');
                });
        ");

        $this->view->registerJs($js);
    }
}
