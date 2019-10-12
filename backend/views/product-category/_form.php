<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use kartik\tree\Module;
use kartik\tree\TreeView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\View;
use dosamigos\tinymce\TinyMce;
use common\models\Tag;
use common\models\Keyword;

/**
 * @var View        $this
 * @var ProductCategory $node
 * @var ActiveForm  $form
 * @var array       $formOptions
 * @var string      $keyAttribute
 * @var string      $nameAttribute
 * @var string      $iconAttribute
 * @var string      $iconTypeAttribute
 * @var string      $iconsList
 * @var string      $action
 * @var array       $breadcrumbs
 * @var array       $nodeAddlViews
 * @var mixed       $currUrl
 * @var boolean     $showIDAttribute
 * @var boolean     $showNameAttribute
 * @var boolean     $showFormButtons
 * @var boolean     $allowNewRoots
 * @var string      $nodeSelected
 * @var array       $params
 * @var string      $keyField
 * @var string      $nodeView
 * @var string      $noNodesMessage
 * @var boolean     $softDelete
 * @var string      $modelClass
 */
?>


