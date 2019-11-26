<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 07.03.2019
 * Time: 7:27
 */

namespace backend\helpers\js;

use yii\web\View;

class BaseJsHelper
{

    /**
     * @var View
     */
    protected $view;

    protected $keyCounter = 0;

    public function __construct(View $view = null)
    {
        $this->view = $view;
    }

    /**
     * @param View $view
     *
     * @return $this
     */
    public function setView(View $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        return $this->view;
    }

    /**
     * Build unique script key
     * @return string
     */
    protected function getJSKey(string $obj): string
    {
        return static::class . ' - ' . $obj . ' - ' . ($this->keyCounter++);
    }
}
