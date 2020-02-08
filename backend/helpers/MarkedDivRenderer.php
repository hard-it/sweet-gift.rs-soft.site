<?php

namespace backend\helpers;

use yii\helpers\ArrayHelper;

/**
 * Class MarkedDivRenderer
 * @package backend\helpers
 */
class MarkedDivRenderer extends \unclead\multipleinput\renderers\DivRenderer
{

    /**
     * Returns an array of JQuery sortable plugin options for MarkedDivRenderer
     * @return array
     */
    protected function getJsSortableOptions()
    {
        return ArrayHelper::merge(parent::getJsSortableOptions(),
            [
                'placeholder'       => '<div class="placeholder">',
            ]);
    }

}