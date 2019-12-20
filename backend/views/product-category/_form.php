<?php
/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2019
 * @package   yii2-tree-manager
 * @version   1.1.2
 */

use kartik\form\ActiveForm;
use kartik\tree\Module;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\ProductCategory;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\widgets\Select2;
use common\models\Tag;
use common\models\Keyword;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\renderers\DivRenderer;
use unclead\multipleinput\renderers\BaseRenderer;
use mihaildev\elfinder\InputFile;
use backend\helpers\js\MultiInputHelper;

/**
 * @var View            $this
 * @var ProductCategory $node
 * @var ActiveForm      $form
 * @var array           $formOptions
 * @var string          $keyAttribute
 * @var string          $nameAttribute
 * @var string          $iconAttribute
 * @var string          $iconTypeAttribute
 * @var array|string    $iconsList
 * @var string          $formAction
 * @var array           $breadcrumbs
 * @var array           $nodeAddlViews
 * @var mixed           $currUrl
 * @var boolean         $isAdmin
 * @var boolean         $showIDAttribute
 * @var boolean         $showNameAttribute
 * @var boolean         $showFormButtons
 * @var boolean         $allowNewRoots
 * @var string          $nodeSelected
 * @var string          $nodeTitle
 * @var string          $nodeTitlePlural
 * @var array           $params
 * @var string          $keyField
 * @var string          $nodeView
 * @var string          $nodeAddlViews
 * @var array           $nodeViewButtonLabels
 * @var string          $noNodesMessage
 * @var boolean         $softDelete
 * @var string          $modelClass
 * @var string          $defaultBtnCss
 * @var string          $treeManageHash
 * @var string          $treeSaveHash
 * @var string          $treeRemoveHash
 * @var string          $treeMoveHash
 * @var string          $hideCssClass
 */

?>

<?php
/**
 * SECTION 1: Initialize node view params & setup helper methods.
 */
?>
<?php
extract($params);
$session     = Yii::$app->has('session') ? Yii::$app->session : null;
$resetTitle  = Yii::t('kvtree', 'Reset');
$submitTitle = Yii::t('kvtree', 'Save');

// parse parent key
if ($node->isNewRecord) {
    $parentKey = empty($parentKey) ? '' : $parentKey;
} elseif (empty($parentKey)) {
    $parent    = $node->parents(1)->one();
    $parentKey = empty($parent) ? '' : Html::getAttributeValue($parent, $keyAttribute);
}

/** @var Module $module */
$module = TreeView::module();

// active form instance
$form = ActiveForm::begin(['action' => $formAction, 'options' => $formOptions]);

// helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) use ($hideCssClass) {
    $class = "alert alert-{$type}";
    if ($hide) {
        $class .= ' ' . $hideCssClass;
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

// node identifier
$id = $node->isNewRecord ? null : $node->$keyAttribute;
// breadcrumbs
if (array_key_exists('depth', $breadcrumbs) && $breadcrumbs['depth'] === null) {
    $breadcrumbs['depth'] = '';
} elseif (!empty($breadcrumbs['depth'])) {
    $breadcrumbs['depth'] = (string)$breadcrumbs['depth'];
}
// icons list
$icons = is_array($iconsList) ? array_values($iconsList) : $iconsList;
?>

<?php
/**
 * SECTION 2: Initialize hidden attributes. In case you are extending this and creating your own view, it is mandatory
 * to set all these hidden inputs as defined below.
 */
?>
<?= Html::hiddenInput('nodeTitle', $nodeTitle) ?>
<?= Html::hiddenInput('nodeTitlePlural', $nodeTitlePlural) ?>
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
<?= Html::hiddenInput('treeManageHash', $treeManageHash) ?>
<?= Html::hiddenInput('treeRemoveHash', $treeRemoveHash) ?>
<?= Html::hiddenInput('treeMoveHash', $treeMoveHash) ?>
<?php
/**
 * BEGIN VALID NODE DISPLAY
 */
?>
<?php if (!$node->isNewRecord || !empty($parentKey)): ?>
    <?php
    $isAdmin     = ($isAdmin == true || $isAdmin === "true"); // admin mode flag
    $inputOpts   = [];                                      // readonly/disabled input options for node
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
    $depth     = ArrayHelper::getValue($breadcrumbs, 'depth', '');
    $glue      = ArrayHelper::getValue($breadcrumbs, 'glue', '');
    $activeCss = ArrayHelper::getValue($breadcrumbs, 'activeCss', '');
    $untitled  = ArrayHelper::getValue($breadcrumbs, 'untitled', '');
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
            <div class="float-right pull-right">
                <?= Html::resetButton(
                    ArrayHelper::getValue($nodeViewButtonLabels, 'reset', $resetTitle),
                    ['class' => 'btn ' . $defaultBtnCss, 'title' => $resetTitle]
                ) ?>
                <?= Html::submitButton(
                    ArrayHelper::getValue($nodeViewButtonLabels, 'submit', $submitTitle),
                    ['class' => 'btn btn-primary', 'title' => $submitTitle]
                ) ?>
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
    <?php if ($iconsList == 'text' || $iconsList == 'none'): ?>
        <?php if ($showIDAttribute && $showNameAttribute): ?>
            <div class="row">
                <div class="col-xs-4">
                    <?= $keyField ?>
                </div>
                <div class="col-xs-8">
                    <?php
                    echo $form->field($node, 'Code')->textInput();
                    ?>
                    <?= $nameField ?>
                </div>
            </div>
        <?php else: ?>
            <?= $keyField ?>
            <?php
            echo $form->field($node, 'Code')->textInput();
            ?>
            <?= $nameField ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-12">
            </div>
        </div>
        <?php if ($iconsList === 'text'): ?>
            <div class="row">
                <div class="col-xs-4">
                    <?= $form->field($node, $iconTypeAttribute)->dropdownList([
                        TreeView::ICON_CSS => 'CSS Suffix',
                        TreeView::ICON_RAW => 'Raw Markup',
                    ], $inputOpts) ?>
                </div>
                <div class="col-xs-8">
                    <?= $form->field($node, $iconAttribute)->textInput($inputOpts) ?>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="row">
            <div class="col-xs-6">
                <?= $keyField ?>
                <?= Html::activeHiddenInput($node, $iconTypeAttribute) ?>
                <?php
                echo $form->field($node, 'Code')->textInput();
                ?>
                <?= $nameField ?>
            </div>
            <div class="col-xs-6">
                <?= /** @noinspection PhpUndefinedMethodInspection */
                $form->field($node, $iconAttribute)->multiselect($iconsList, [
                    'item'     => function ($index, $label, $name, $checked, $value) use ($inputOpts) {
                        if ($index == 0 && $value == '') {
                            $checked = true;
                            $value   = '';
                        }

                        return '<div class="radio">' . Html::radio($name, $checked, [
                                'value'    => $value,
                                'label'    => $label,
                                'disabled' => !empty($inputOpts['readonly']) || !empty($inputOpts['disabled']),
                            ]) . '</div>';
                    },
                    'selector' => 'radio',
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php
    /**
     * SECTION 8: Additional views part 2 - before admin zone.
     */

    // РЕДАКТОР ОПИСАНИЯ

    echo $form->field($node, 'Description')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',
            [
                //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'preset' => 'standart',
                //по умолчанию false
                'inline' => false,
                'rows'   => 10,
            ]
        ),
    ]);

    echo Html::beginTag('div', ['class' => 'row']);

    echo $form->field($node, 'Images')->widget(MultipleInput::class, [
        // max images count
        'max'               => 10,
        // should be at least 2 rows
        //'min'               => 2,
        'rendererClass'     => \unclead\multipleinput\renderers\DivRenderer::class,
        'allowEmptyList'    => true,
        'enableGuessTitle'  => true,
        'cloneButton'       => false,
        'sortable'          => true,
        // show add button in the footer
        'addButtonPosition' => MultipleInput::POS_HEADER,
        'id'                => 'node-images',
        'class'             => 'multiple-input col-md-12 col-xs-12 col-lg-12',
        'columns'           => [
            [
                'name'  => 'PreviewImages',
                'type'  => 'static',
                'value' => function ($data) {
                    $url = $data['url'] ?? ProductCategory::DEFAULT_IMAGE;

                    if (!strlen($url)) {
                        $url = ProductCategory::DEFAULT_IMAGE;
                    }

                    return
                        Html::tag('div',
                            Html::img(
                                Url::toRoute([$url]),
                                [
                                    'class'          => 'multiple-input-image',
                                    //'data-placement' => "top",
                                    //'data-toggle'    => "tooltip",
                                    //'data-trigger'   => 'hover',
                                    //'data-html'      => "true",
                                    //'title'          => "<img src='$url'>",
                                ])
                            . Html::tag('div',
                                '',
                                ['class' => 'container']
                            ),
                            ['class' => 'image-preview-container']

                        );
                },
            ],

            [
                'name'    => 'url',
                'type'    => InputFile::class,
                'title'   => '',
                'options' => [
                    'language'      => 'ru',
                    // вставляем название контроллера, по умолчанию равен elfinder
                    'controller'    => 'elfinder',
                    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                    'filter'        => 'image',
                    'template'      => '<div class="hidden-image-name">{input}</div><div class="input-group multiple-input-elfinder"><span class="input-group-btn">{button}</span></div>',
                    'options'       => ['class' => 'form-control'],
                    'buttonOptions' => ['class' => 'btn btn-primary btn-select-image glyphicon glyphicon-camera'],
                    'buttonName'    => Yii::t('elfinder', ''),
                    // возможность выбора нескольких файлов
                    'multiple'      => false,
                ],

            ],

            [
                'name'    => 'name',
                'title'   => '',
                'options' => [
                    'class' => 'image-title',
                    'placeholder' => Yii::t('app', 'Заголовок'),
                ],

            ],

            [
                'name'    => 'order',
                'type'    => 'hiddenInput',
                'title'   => '',
                'options' => [
                        'class' => 'image-index',
                ],

            ],
        ],
        //'theme'             => BaseRenderer::THEME_BS,
        'layoutConfig'      => [
            'offsetClass'       => 'col-xs-offset-0 col-md-offset-0',
            'wrapperClass'      => 'col-md-10 col-lg-10 col-xs-10 col-xs-offset-0 col-md-offset-0 node-images-wrapper',
            'buttonAddClass'    => 'col-md-offset-11 col-xs-offset-11 col-lg-offset-11 col-sm-offset-10 image-button-offset-1',
            'buttonActionClass' => 'col-xs-offset-10 col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-0 image-button-offset-1',
            //'buttonActionClass' => 'col-xs-offset-0 col-lg-offset-0 col-md-offset-0 col-xs-0 image-button-offset-1',
        ],

        'rowOptions' => [
            'class' => 'col-md-6 col-lg-4 col-xs-12 col-xs-offset-0',
        ],

    ]);

    echo Html::endTag('div');

    echo Html::beginTag('div', ['class' => 'row']);

    echo $form->field($node, 'Tags')->widget(Select2::classname(), [
        'data'          => Tag::getList(),
        'value'         => $node->Tags,
        'options'       => ['placeholder' => 'Тэги...', 'multiple' => true],
        'pluginOptions' => [
            'tags'               => true,
            'tokenSeparators'    => [','],
            'maximumInputLength' => 64,
        ],
    ]);

    echo Html::endTag('div');

    echo Html::beginTag('div', ['class' => 'row']);

    echo $form->field($node, 'Keywords')->widget(Select2::classname(), [
        'data'          => Keyword::getList(),
        'value'         => $node->Keywords,
        'options'       => ['placeholder' => 'Ключевые слова...', 'multiple' => true],
        'pluginOptions' => [
            'tags'               => true,
            'tokenSeparators'    => [','],
            'maximumInputLength' => 64,
        ],
    ]);

    echo Html::endTag('div');

    ?>
    <?= $renderContent(Module::VIEW_PART_2) ?>

    <?php
    /**
     * SECTION 9: Administrator attributes zone.
     */
    ?>
    <?php if ($isAdmin): ?>
        <h4><?= Yii::t('kvtree', 'Admin Settings') ?></h4>

        <?php
        /**
         * SECTION 10: Additional views part 3 - within admin zone BEFORE mandatory attributes.
         */
        ?>
        <?= $renderContent(Module::VIEW_PART_3) ?>

        <?php
        /**
         * SECTION 11: Default mandatory admin controlled attributes.
         */
        ?>
        <div class="row">
            <div class="col-xs-4">
                <?= $form->field($node, 'active')->checkbox() ?>
                <?= $form->field($node, 'visible')->checkbox() ?>
                <?= $form->field($node, 'readonly')->checkbox() ?>
                <?= $form->field($node, 'disabled')->checkbox() ?>
                <?= $form->field($node, 'child_allowed')->checkbox() ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($node, 'selected')->checkbox() ?>
                <?= $form->field($node, 'collapsed')->checkbox($flagOptions) ?>
                <?= $form->field($node, 'removable')->checkbox() ?>
                <?= $form->field($node, 'removable_all')->checkbox($flagOptions) ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($node, 'movable_u')->checkbox() ?>
                <?= $form->field($node, 'movable_d')->checkbox() ?>
                <?= $form->field($node, 'movable_l')->checkbox() ?>
                <?= $form->field($node, 'movable_r')->checkbox() ?>
            </div>
        </div>

        <?php
        /**
         * SECTION 12: Additional views part 4 - within admin zone AFTER mandatory attributes.
         */
        ?>
        <?= $renderContent(Module::VIEW_PART_4) ?>
    <?php endif; ?>
    <?php
    /**
     * SECTION 13: Additional views part 5 accessible by all users after admin zone.
     */
    ?>
    <?= $renderContent(Module::VIEW_PART_5) ?>
<?php else: ?>
    <?= $noNodesMessage ?>
<?php endif; ?>
<?php
/**
 * END VALID NODE DISPLAY
 */
?>
<?php
ActiveForm::end();
MultiInputHelper::registerImageScript($this, 'node-images');
//MultiInputHelper::registerTooltip($this);
//MultiInputHelper::registerSortableOrder($this, 'node-images', '');
MultiInputHelper::registerUpdateImagesIndexScript($this, 'product-category-tree-nodeform', 'image-index');
?>
