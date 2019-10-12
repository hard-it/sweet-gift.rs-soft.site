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
 * @var View            $this
 * @var ProductCategory $node
 * @var ActiveForm      $form
 * @var array           $formOptions
 * @var string          $keyAttribute
 * @var string          $nameAttribute
 * @var string          $iconAttribute
 * @var string          $iconTypeAttribute
 * @var string          $iconsList
 * @var string          $action
 * @var array           $breadcrumbs
 * @var array           $nodeAddlViews
 * @var mixed           $currUrl
 * @var boolean         $showIDAttribute
 * @var boolean         $showNameAttribute
 * @var boolean         $showFormButtons
 * @var boolean         $allowNewRoots
 * @var boolean         $isAdmin
 * @var string          $nodeSelected
 * @var array           $params
 * @var string          $keyField
 * @var string          $nodeView
 * @var string          $noNodesMessage
 * @var boolean         $softDelete
 * @var string          $modelClass
 */
?>

<?php
/**
 * SECTION 1: Initialize node view params & setup helper methods.
 */

extract($params);
$session = Yii::$app->has('session') ? Yii::$app->session : null;

// parse parent key
if ($noNodesMessage) {
    $parentKey = '';
} elseif (empty($parentKey)) {
    $parent    = $node->parents(1)->one();
    $parentKey = empty($parent) ? '' : Html::getAttributeValue($parent, $keyAttribute);
}

// tree manager module
$module = TreeView::module();

// active form instance
$form = ActiveForm::begin(['action' => $action, 'options' => $formOptions]);

// helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) {
    $class = "alert alert-{$type}";
    if ($hide) {
        $class .= ' hide';
    }

    return Html::tag('div', '<div>' . $body . '</div>', ['class' => $class]);
};

// helper function to render additional view content
$renderContent = function ($part) use ($nodeAddlViews, $params, $form) {
    if (empty($nodeAddlViews[$part])) {
        return '';
    }
    $p         = $params;
    $p['form'] = $form;

    return $this->render($nodeAddlViews[$part], $p);
};
?>

<?php
/**
 * SECTION 2: Initialize hidden attributes. In case you are extending this and creating your own view, it is mandatory
 * to set all these hidden inputs as defined below.
 */
?>
<?= Html::hiddenInput('treeNodeModify', $node->isNewRecord) ?>
<?= Html::hiddenInput('parentKey', $parentKey) ?>
<?= Html::hiddenInput('currUrl', $currUrl) ?>
<?= Html::hiddenInput('modelClass', $modelClass) ?>
<?= Html::hiddenInput('nodeSelected', $nodeSelected) ?>

<?php
/**
 * SECTION 3: Hash signatures to prevent data tampering. In case you are extending this and creating your own view, it
 * is mandatory to include this section below.
 */
?>

<?php
$security = Yii::$app->security;
$id       = $node->isNewRecord ? null : $node->$keyAttribute;

// save signature
$dataToHash = !!$node->isNewRecord . $currUrl . $modelClass;
echo Html::hiddenInput('treeSaveHash', $security->hashData($dataToHash, $module->treeEncryptSalt));

// manage signature
if (array_key_exists('depth', $breadcrumbs) && $breadcrumbs['depth'] === null) {
    $breadcrumbs['depth'] = '';
} elseif (!empty($breadcrumbs['depth'])) {
    $breadcrumbs['depth'] = (string)$breadcrumbs['depth'];
}
$icons      = is_array($iconsList) ? array_values($iconsList) : $iconsList;
$dataToHash = $modelClass . !!$isAdmin . !!$softDelete . !!$showFormButtons . !!$showIDAttribute .
    !!$showNameAttribute . $currUrl . $nodeView . $nodeSelected . Json::encode($formOptions) .
    Json::encode($nodeAddlViews) . Json::encode($icons) . Json::encode($breadcrumbs);
echo Html::hiddenInput('treeManageHash', $security->hashData($dataToHash, $module->treeEncryptSalt));

// remove signature
$dataToHash = $modelClass . $softDelete;
echo Html::hiddenInput('treeRemoveHash', $security->hashData($dataToHash, $module->treeEncryptSalt));

// move signature
$dataToHash = $modelClass . $allowNewRoots;
echo Html::hiddenInput('treeMoveHash', $security->hashData($dataToHash, $module->treeEncryptSalt));

// id
echo Html::activeHiddenInput($node, $keyAttribute);
?>

<?php
/**
 * BEGIN VALID NODE DISPLAY
 */
?>
<?php if (!$noNodesMessage): ?>
    <?php
    $isAdmin     = ($isAdmin == true || $isAdmin === "true"); // admin mode flag
    $inputOpts   = ['disabled' => false];                                      // readonly/disabled input options for node
    $flagOptions = ['class' => 'kv-parent-flag'];         // node options for parent/child

    /**
     * the primary key input field
     */
    if ($showIDAttribute) {
        $options = ['readonly' => true];
        if ($node->isNewRecord) {
            $options['value'] = Yii::t('kvtree', '(new)');
        }
        $keyField = $form->field($node, $keyAttribute)->textInput($options);
    } else {
        $keyField = Html::activeHiddenInput($node, $keyAttribute);
    }

    /**
     * initialize for create or update
     */
    $depth     = ArrayHelper::getValue($breadcrumbs, 'depth');
    $glue      = ArrayHelper::getValue($breadcrumbs, 'glue');
    $activeCss = ArrayHelper::getValue($breadcrumbs, 'activeCss');
    $untitled  = ArrayHelper::getValue($breadcrumbs, 'untitled');
    $name      = $node->getBreadcrumbs($depth, $glue, $activeCss, $untitled);
    if ($node->isNewRecord && !empty($parentKey) && $parentKey !== TreeView::ROOT_KEY) {
        /**
         * @var Tree $modelClass
         * @var Tree $parent
         */
        if (empty($depth)) {
            $depth = null;
        }
        if ($depth === null || $depth > 0) {
            $parent = $modelClass::findOne($parentKey);
            $name   = $parent->getBreadcrumbs($depth, $glue, null) . $glue . $name;
        }
    }
    if ($node->isReadonly()) {
        $inputOpts['readonly'] = true;
    }
    if ($node->isDisabled()) {
        $inputOpts['disabled'] = true;
    }
    if ($node->isLeaf()) {
        $flagOptions['disabled'] = true;
    }

    $nameField = $showNameAttribute ? $form->field($node, $nameAttribute)->textInput($inputOpts) : '';
    ?>
    <?php
    /**
     * SECTION 4: Setup form action buttons.
     */
    ?>
    <div class="kv-detail-heading">
        <?php if (empty($inputOpts['disabled']) || ($isAdmin && $showFormButtons)): ?>
            <div class="pull-right">
                <button type="reset" class="btn btn-default" title="<?= Yii::t('kvtree', 'Reset') ?>">
                    <i class="glyphicon glyphicon-repeat"></i>
                </button>
                <button type="submit" class="btn btn-primary" title="<?= Yii::t('kvtree', 'Save') ?>">
                    <i class="glyphicon glyphicon-floppy-disk"></i>
                </button>
            </div>
        <?php endif; ?>
        <div class="kv-detail-crumbs"><?= $name ?></div>
        <div class="clearfix"></div>
    </div>

    <?php
    /**
     * SECTION 5: Setup alert containers. Mandatory to set this up.
     */
    ?>
    <div class="kv-treeview-alerts">
        <?php
        if ($session && $session->hasFlash('success')) {
            echo $showAlert('success', $session->getFlash('success'), false);
        } else {
            echo $showAlert('success');
        }
        if ($session && $session->hasFlash('error')) {
            echo $showAlert('danger', $session->getFlash('error'), false);
        } else {
            echo $showAlert('danger');
        }
        echo $showAlert('warning');
        echo $showAlert('info');
        ?>
    </div>

    <?php
    /**
     * SECTION 6: Additional views part 1 - before all form attributes.
     */
    ?>
    <?php
    echo $renderContent(Module::VIEW_PART_1);
    ?>

    <?php
    /**
     * SECTION 7: Basic node attributes for editing.
     */
    ?>
    <?= $nameField ?>

    <?php

    echo $form->field($node, 'saveFromTree')->hiddenInput(['value' => 1])->label(false);


    // РЕДАКТОР ОПИСАНИЯ
    echo $form->field($node, 'Description')->widget(TinyMce::class, [
        'options'       => ['rows' => 20],
        'language'      => 'ru',
        'clientOptions' => [
            'file_browser_callback' => new yii\web\JsExpression("function(field_name, url, type, win) {
			window.open('" . yii\helpers\Url::to(['/imagemanager/manager', 'view-mode' => 'iframe', 'select-type' => 'tinymce']) . "&tag_name='+field_name,'','width=800,height=540 ,toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no');
		}"),
            'plugins'               => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code",
                "insertdatetime media table contextmenu paste image pagebreak",
            ],
            'toolbar'               => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | pagebreak | code",
            'branding'              => false,
            'image_advtab'          => true,
        ],
    ]);
    ?>
    <?php
    /**
     * SECTION 8: Additional views part 2 - before admin zone.
     */
    ?>
    <?= $renderContent(Module::VIEW_PART_2) ?>

    <?php
    /**
     * SECTION 9: Administrator attributes zone.
     */
    ?>
    <?= $renderContent(Module::VIEW_PART_3) ?>
<?php else: ?>
    <?= $noNodesMessage ?>
<?php endif; ?>
<?php
/**
 * END VALID NODE DISPLAY
 */
?>
<?php ActiveForm::end(); ?>
