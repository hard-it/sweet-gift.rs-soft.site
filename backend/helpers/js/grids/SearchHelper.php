<?php

namespace backend\helpers\js\grids;

use yii\web\View;
use yii\web\JsExpression;
use backend\helpers\js\BaseJsHelper;

/**
 * Class SearchHelper
 * @package backend\helpers\js\grids
 */
class SearchHelper extends BaseJsHelper
{
    /**
     * @param string $id
     * @param string $pjaxId
     * @param string $url
     *
     * @return mixed
     */
    public function generatePjaxResetForm(string $id, string $pjaxId, string $url)
    {
        $js = new JsExpression("
        $(function () {
        $('#{$id}').on('click', function (xhr, textStatus, error, options) {
                xhr.preventDefault();
                let pjaxUrl = '{$url}';
                $.pjax.reload({
                    container:'#{$pjaxId}',
                    url: pjaxUrl,
                    push: false,
                    replace: false,
                    pushRedirect: false,
                    replaceRedirect: false,
                    async:true
                });
            })
        });
        ");

        return $js->expression;
    }
}
