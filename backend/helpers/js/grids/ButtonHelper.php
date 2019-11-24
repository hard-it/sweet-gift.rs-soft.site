<?php

namespace backend\helpers\js\grids;

use backend\helpers\js\BaseJsHelper;
use yii\web\JsExpression;

/**
 * Class ButtonHelper
 * @package backend\helpers\js\grids
 */
class ButtonHelper extends BaseJsHelper
{
    /**
     * @param string $tdClass
     * @param string $baseUrl
     *
     * @return string
     */
    public function generateUpdateGridRowScript(string $tdClass, string $baseUrl)
    {
        $js = new JsExpression("
            $('document').ready(function() {
                $('{$tdClass}').on('click', function (e) {
                    let currentRow = $(this).closest('tr');
                    if (currentRow !== undefined) {
                        let currentId = currentRow.attr('data-key');
                        if (currentId !== undefined) {
                            alert($baseUrl+'?id='+currentId);
                        }
                    }
                });
            });
        ");

        return $js->expression;
    }
}
