<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\tree\TreeViewInput;
use common\models\ProductCategory;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\widgets\Select2;
use common\models\Tag;
use common\models\Keyword;
use unclead\multipleinput\MultipleInput;
use mihaildev\elfinder\InputFile;
use backend\helpers\js\MultiInputHelper;
use kartik\number\NumberControl;
use common\models\ProductType;
use backend\helpers\js\grids\ButtonHelper as GridButtonHelper;
use backend\helpers\js\forms\ButtonHelper as FormButtonHelper;
use unclead\multipleinput\renderers\BaseRenderer;
use backend\helpers\MarkedDivRenderer;

/* @var $this yii\web\View */
/* @var $model common\models\ProductType */
/* @var $form yii\widgets\ActiveForm */

$buttonHelper = new GridButtonHelper($this);

echo Html::beginTag('div', ['class' => ' box box-no-top-border']);

echo Html::beginTag('div', ['class' => 'product-type-form']);

$form = ActiveForm::begin(
    [
        'id' => 'product-type-form',
    ]
);

echo Html::beginTag('div', ['class' => 'row']);

echo Html::beginTag('div', ['class' => 'col-lg-2 col-xs-12']);
echo $form->field($model, 'Code')
    ->textInput(['maxlength' => true])
    ->label(null, ['maxlength' => true]);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-lg-5 col-xs-12']);
echo $form->field($model, 'Name')
    ->textInput(['maxlength' => true])
    ->label(null, ['maxlength' => true]);;

echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-lg-5 col-xs-12']);
echo $form->field($model, 'Alias', [
    'addon' => [
        'append' => ['content' => '<button class="btn btn-danger btn-clear-url"><i class="glyphicon glyphicon-remove"></i></button>', 'asButton' => true],
    ],
])
    ->textInput([
        'class' => 'url-input',
    ]);
echo Html::endTag('div');


echo Html::beginTag('div', ['class' => 'col-lg-12']);
echo $form->field($model, 'Category')->widget(TreeViewInput::classname(),
    [
        'name'           => 'Category',
        'value'          => $model->Category, // preselected values
        'query'          => ProductCategory::find()->addOrderBy('root, lft, Name'),
        'headingOptions' => ['label' => 'Категории'],
        'rootOptions'    => ['label' => ''],
        'fontAwesome'    => true,
        'asDropdown'     => true,
        'multiple'       => false,
        'options'        => [
            'disabled' => false,
        ],
    ]);
echo Html::endTag('div');
echo Html::endTag('div');

// РЕДАКТОР ОПИСАНИЯ

echo $form->field($model, 'Description')->widget(CKEditor::className(), [
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

echo Html::beginTag('div', ['class' => 'col-12 col-lg-12']);

echo $form->field($model, 'Images')->widget(MultipleInput::class, [
    // max images count
    'max'               => 10,
    // should be at least 2 rows
    //'min'               => 2,
    'rendererClass'     => MarkedDivRenderer::class,
    'allowEmptyList'    => true,
    //'enableGuessTitle'  => true,
    'cloneButton'       => false,
    'sortable'          => true,
    // show add button in the footer
    'addButtonPosition' => MultipleInput::POS_HEADER,
    'id'                => 'node-images',
    'class'             => 'multiple-input col-md-12 col-xs-12 col-lg-12',
    'columns'           => [
        [
            'name'    => ProductType::IMAGE_URL,
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
            'name'  => 'PreviewImages',
            'type'  => 'static',
            'value' => function ($data) {
                $url = $data['url'] ?? ProductType::DEFAULT_IMAGE;

                if (!strlen($url)) {
                    $url = ProductType::DEFAULT_IMAGE;
                }

                return
                    Html::tag('div',
                        Html::img(
                            Url::toRoute([$url]),
                            [
                                'class' => 'multiple-input-image',
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
            'name'    => ProductType::IMAGE_NAME,
            'title'   => '',
            'options' => [
                'class'       => 'image-title',
                'placeholder' => Yii::t('app', 'Заголовок'),
            ],

        ],

        [
            'name'    => ProductType::IMAGE_ORDER,
            'type'    => 'hiddenInput',
            'title'   => '',
            'options' => [
                'class' => 'image-index',
            ],

        ],
    ],
    'theme'             => BaseRenderer::THEME_BS,
    //'theme'             => BaseRenderer::THEME_DEFAULT,
    'layoutConfig'      => [
        'offsetClass'       => 'col-xs-offset-0 col-md-offset-0',
        //'wrapperClass'      => 'col-10 col-md-10 col-lg-10 col-xs-10 col-xs-offset-0 col-md-offset-0 node-images-wrapper',
        'wrapperClass'      => 'col-12 col-md-12 col-lg-12 col-xs-12 col-xs-offset-0 col-md-offset-0 node-images-wrapper',
        //'buttonAddClass'    => 'col-md-offset-11 col-xs-offset-11 col-lg-offset-11 col-sm-offset-11 col-1 col-md-1 col-xs-1 col-lg-1 col-sm-1',
        'buttonAddClass'    => 'col-md-offset-12 col-xs-offset-12 col-lg-offset-12 col-sm-offset-12 col-1 col-md-1 col-xs-1 col-lg-1 col-sm-1 product-type-add-button',
        //'buttonActionClass' => 'col-xs-offset-10 col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-0 image-button-offset-1',
        'buttonActionClass' => 'col-xs-offset-12 col-lg-offset-12 col-md-offset-12 col-sm-offset-12 col-xs-0 image-button-offset-1',

    ],

    'rowOptions' => [
        'class' => 'col-md-6 col-lg-4 col-xs-12 col-xs-offset-0',
    ],

]);

echo Html::endTag('div');
echo Html::endTag('div');


echo $form->field($model, 'Tags')->widget(Select2::classname(), [
    'data'          => Tag::getList(),
    'value'         => $model->Tags,
    'options'       => ['placeholder' => 'Тэги...', 'multiple' => true],
    'pluginOptions' => [
        'tags'               => true,
        'tokenSeparators'    => [','],
        'maximumInputLength' => 64,
    ],
]);


echo $form->field($model, 'Keywords')->widget(Select2::classname(), [
    'data'          => Keyword::getList(),
    'value'         => $model->Keywords,
    'options'       => ['placeholder' => 'Ключевые слова...', 'multiple' => true],
    'pluginOptions' => [
        'tags'               => true,
        'tokenSeparators'    => [','],
        'maximumInputLength' => 64,
    ],
]);

echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-6']);
echo $form->field($model, 'MinimalQuantity')->widget(NumberControl::classname(), [
    'maskedInputOptions' => [
        'prefix'         => '',
        'suffix'         => '',
        'allowMinus'     => false,
        'groupSeparator' => '',
        'radixPoint'     => '.',
        'digits'         => 2,
    ],
    'displayOptions'     => [
        'placeholder' => Yii::t('app', 'Введите количество...'),
    ],
]);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-6']);
echo $form->field($model, 'Cost')->widget(NumberControl::classname(), [
    'maskedInputOptions' => [
        'prefix'         => '',
        'suffix'         => '',
        'allowMinus'     => false,
        'groupSeparator' => '',
        'radixPoint'     => '.',
        'digits'         => 2,
    ],
    'displayOptions'     => [
        'placeholder' => Yii::t('app', 'Введите цену...'),
    ],
]);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-6']);
echo $form->field($model, 'ShelfLife')->widget(NumberControl::classname(), [
    'maskedInputOptions' => [
        'prefix'         => '',
        'suffix'         => '',
        'allowMinus'     => false,
        'groupSeparator' => '',
        'radixPoint'     => '',
        'digits'         => 0,
    ],
    'displayOptions'     => [
        'placeholder' => Yii::t('app', 'Введите срок хранения...'),
    ],
]);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-6']);
echo $form->field($model, 'Measure')->dropDownList(ProductType::MEASURE_VALUES);
echo Html::endTag('div');

echo Html::endTag('div');
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'form-group']);
echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-sm-4 col-xs-6']);
echo Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-lg btn-primary btn-success fa fa-save btn-block btn-flat']);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-sm-4 col-xs-6']);
echo Html::submitButton(Yii::t('app', 'Назад'), ['id' => 'previous-button', 'class' => 'btn btn-lg btn-primary fa fa-undo btn-block btn-flat btn-back']);
echo Html::endTag('div');
echo Html::endTag('div');
echo Html::endTag('div');

ActiveForm::end();

MultiInputHelper::registerImageScript($this, 'node-images');
//MultiInputHelper::registerTooltip($this);
//MultiInputHelper::registerSortableOrder($this, 'node-images', '');
MultiInputHelper::registerUpdateImagesIndexScript($this, 'product-type-form', 'image-index');


echo Html::endTag('div');

echo Html::endTag('div');

$buttonHelper->registerPreviousMoveScript('previous-button');

$clearScript = new FormButtonHelper($this);
$clearScript->registerClearInputTextValue('url-input', 'btn-clear-url');
