<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
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

/* @var $this yii\web\View */
/* @var $model common\models\ProductType */
/* @var $form yii\widgets\ActiveForm */

echo Html::beginTag('div', ['class' => 'product-type-form']);

$form = ActiveForm::begin();

    echo Html::beginTag('div', ['class' => 'row']);

        echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-12']);
            echo $form->field($model, 'Code')
                ->textInput(['maxlength' => true ])
                ->label(null, ['maxlength' => true ]);
        echo Html::endTag('div');

        echo Html::beginTag('div', ['class' => 'col-lg-9 col-xs-12']);
            echo $form->field($model, 'Name')
                ->textInput(['maxlength' => true])
                ->label(null, ['maxlength' => true]);;

        echo Html::endTag('div');


        echo Html::beginTag('div', ['class' => 'col-lg-12']);
            echo $form->field($model, 'Category')->widget(TreeViewInput::classname(),
                [
                    'name' => 'Category',
                    'value' => $model->Category, // preselected values
                    'query' =>ProductCategory::find()->addOrderBy('root, lft, Name'),
                    'headingOptions' => ['label' => 'Категории'],
                    'rootOptions' => ['label'=>''],
                    'fontAwesome' => true,
                    'asDropdown' => true,
                    'multiple' => false,
                    'options' => [
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

echo $form->field($model, 'Images')->widget(MultipleInput::class, [
    // max images count
    'max'               => 10,
    // should be at least 2 rows
    //'min'               => 2,
    'rendererClass'     => \unclead\multipleinput\renderers\DivRenderer::class,
    'allowEmptyList'    => true,
    'enableGuessTitle'  => true,
    'cloneButton'       => false,
    'sortable'          => false,
    // show add button in the footer
    'addButtonPosition' => MultipleInput::POS_HEADER,
    'id'                => 'node-images',
    'class'             => 'multiple-input col-md-12 col-xs-12 col-lg-12',
    'columns'           => [
        [
            'name'  => 'PreviewImages',
            'type'  => 'static',
            'value' => function ($data) {
                $url = $data['Images'] ?? ProductCategory::DEFAULT_IMAGE;

                if (!strlen($url)) {
                    $url = ProductCategory::DEFAULT_IMAGE;
                }

                return
                    Html::tag('div',
                        Html::img(
                            Url::toRoute([$url]),
                            [
                                'class'          => 'multiple-input-image',
                                'data-placement' => "top",
                                'data-toggle'    => "tooltip",
                                'data-trigger'   => 'hover',
                                'data-html'      => "true",
                                'title'          => "<img src='$url'>",
                            ])
                        .Html::tag('div',
                            '',
                            ['class' => 'container']
                        ),
                        ['class' => 'image-preview-container']

                    );
            },
        ],

        [
            'name'    => 'Images',
            'type'    => InputFile::class,
            'title'   => '',
            'options' => [
                'language'      => 'ru',
                // вставляем название контроллера, по умолчанию равен elfinder
                'controller'    => 'elfinder',
                // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                'filter'        => 'image',
                'template'      => '{input}<div class="input-group multiple-input-elfinder"><span class="input-group-btn">{button}</span></div>',
                'options'       => ['class' => 'form-control'],
                'buttonOptions' => ['class' => 'btn btn-primary btn-select-image glyphicon glyphicon-camera'],
                'buttonName'    => Yii::t('elfinder', ''),
                // возможность выбора нескольких файлов
                'multiple'      => false,
            ],

        ],
    ],
    //'theme'             => BaseRenderer::THEME_BS,
    'layoutConfig'      => [
        'offsetClass'       => 'col-xs-offset-0 col-md-offset-0',
        'wrapperClass'      => 'col-md-10 col-lg-10 col-xs-10 col-xs-offset-0 col-md-offset-0',
        'buttonAddClass'    => 'col-md-offset-11 col-xs-offset-11 col-lg-offset-11 col-sm-offset-10 image-button-offset-1',
        'buttonActionClass' => 'col-xs-offset-10 col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-0 image-button-offset-1',
        //'buttonActionClass' => 'col-xs-offset-0 col-lg-offset-0 col-md-offset-0 col-xs-0 image-button-offset-1',
    ],

    'rowOptions' =>[
        'class' => 'col-md-6 col-lg-4 col-xs-12 col-xs-offset-0',
    ],

]);

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
                    'prefix' => '',
                    'suffix' => '',
                    'allowMinus' => false,
                    'groupSeparator' => '',
                    'radixPoint' => '.',
                    'digits' => 2,
                ],
                'displayOptions' => [
                    'placeholder' => Yii::t('app', 'Введите количество...'),
                ],
            ]);
        echo Html::endTag('div');

         echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-6']);
            echo $form->field($model, 'Cost')->widget(NumberControl::classname(), [
                'maskedInputOptions' => [
                    'prefix' => '',
                    'suffix' => '',
                    'allowMinus' => false,
                    'groupSeparator' => '',
                    'radixPoint' => '.',
                    'digits' => 2,
                ],
                'displayOptions' => [
                    'placeholder' => Yii::t('app', 'Введите цену...'),
                ],
            ]);
        echo Html::endTag('div');

        echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-6']);
            echo $form->field($model, 'ShelfLife')->widget(NumberControl::classname(), [
                'maskedInputOptions' => [
                    'prefix' => '',
                    'suffix' => '',
                    'allowMinus' => false,
                    'groupSeparator' => '',
                    'radixPoint' => '',
                    'digits' => 0,
                ],
                'displayOptions' => [
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
echo Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);
echo Html::endTag('div');

ActiveForm::end();

MultiInputHelper::registerImageScript($this, 'node-images');
MultiInputHelper::registerTooltip($this);

echo Html::endTag('div');

