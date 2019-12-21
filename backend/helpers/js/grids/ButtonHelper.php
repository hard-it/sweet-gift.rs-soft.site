<?php

namespace backend\helpers\js\grids;

use backend\helpers\js\BaseJsHelper;
use yii\web\JsExpression;
use yii\helpers\Url;

/**
 * Class ButtonHelper
 * @package backend\helpers\js\grids
 */
class ButtonHelper extends BaseJsHelper
{
    const PREVIOUS_REDIRECT_URL = 'site/previous';
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

    /**
     * @param string $buttonId
     * @param string $url
     */
    public function registerPreviousMoveScript(string $buttonId, string $url = self::PREVIOUS_REDIRECT_URL)
    {
        $redirectUrl = Url::toRoute($url);

        $js = new JsExpression("
                $('#{$buttonId}').on('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    window.location.href = '$redirectUrl';
                });
        ");

        $this->view->registerJs($js);
    }

}
