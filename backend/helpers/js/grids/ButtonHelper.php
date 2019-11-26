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
     * @param string $elementClass
     * @param string $baseUrl
     *
     * @return string
     */
    public function generateGridButtonScript(string $elementClass, string $baseUrl)
    {
        $js = new JsExpression("
            $(document).ready(function() {
                $('.{$elementClass}').on('click', function (e) {
                    let currentRow = $(this).closest('tr');
                    if (currentRow !== undefined) {
                        let currentId = currentRow.attr('data-key');
                        if (currentId !== undefined) {
                            let url = '$baseUrl'+'?id='+currentId;
                            window.location.href = url;
                        }
                    }
                });
            });
        ");

        return $js->expression;
    }

    /**
     * @param string $elementClass
     * @param string $baseUrl
     *
     * @return string
     */
    public function generateDeleteGridButtonScript(string $elementClass, string $baseUrl, $message)
    {
        $js = new JsExpression("
            $(document).ready(function() {
                $('.{$elementClass}').on('click', function (e) {
                    let deleteButton = this;                
                    krajeeDialog.confirm('$message', function(out) {
                        if(out) {
                            
                            let currentId = $(deleteButton).attr('data-key');
                            if (currentId !== undefined) {
                                    let url = '$baseUrl'+'?id='+currentId;
                                    window.location.href = url;
                            }
                        }
                    });
    
                });
            });
        ");

        return $js->expression;
    }

}
