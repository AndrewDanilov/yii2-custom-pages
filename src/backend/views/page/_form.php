<?php

use andrewdanilov\ckeditor\CKEditor;
use andrewdanilov\custompages\backend\assets\CustomPagesAsset;
use andrewdanilov\custompages\backend\Module;
use andrewdanilov\custompages\common\models\Category;
use andrewdanilov\custompages\common\models\Page;
use andrewdanilov\custompages\common\models\PageTag;
use andrewdanilov\helpers\CKEditorHelper;
use andrewdanilov\helpers\NestedCategoryHelper;
use andrewdanilov\InputImages\InputImages;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model Page */

CustomPagesAsset::register($this);

$elfinder_controller_path = 'elfinder';
$module = Yii::$app->controller->module;
while ($module->module !== null) {
	$elfinder_controller_path = $module->id . '/' . $elfinder_controller_path;
	$module = $module->module;
}
$elfinder_controller_url = Yii::$app->request->baseUrl . '/' . $elfinder_controller_path;
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	<?php if (Module::getInstance()->enableCategories) { ?>
        <?= $form->field($model, 'category_id')->dropDownList(NestedCategoryHelper::getDropdownTree(Category::find(), 0, 'title'), ['prompt' => Yii::t('custompages/page', 'Without Category')]) ?>
	<?php } ?>

	<?php if (Module::getInstance()->enableTags) { ?>
		<?= $form->field($model, 'tagIds')->widget(Select2::class, [
			'data' => ArrayHelper::map(PageTag::find()->all(), 'id', 'name'),
			'language' => Yii::$app->language,
			'options' => [
				'placeholder' => Yii::t('custompages/page', 'Enter tag name...'),
				'multiple' => true,
			],
			'pluginOptions' => [
				'allowClear' => true,
				'tags' => true,
			],
		]); ?>
	<?php } ?>

	<?= $form->field($model, 'image')->widget(InputImages::class) ?>

	<?= $form->field($model, 'text')->widget(CKEditor::class, [
		'editorOptions' => ElFinder::ckeditorOptions($elfinder_controller_path, CKEditorHelper::defaultOptions()),
	]) ?>

	<?= $form->field($model, 'page_template')->dropDownList(Module::getInstance()->getPagesTemplates(), ['prompt' => Yii::t('custompages/page', 'From category settings / Default')]) ?>

	<?= $form->field($model, 'is_main')->checkbox(['label' => Yii::t('custompages/page', 'Use as main page')]) ?>

	<?php if (Module::getInstance()->enableAlbums) { ?>
		<div class="custom-pages-albums">
			<label class="control-label"><?= Yii::t('custompages/page', 'Albums'); ?></label>
			<div class="albums-list">
				<?php if (is_array($model->albums)) { ?>
					<?php foreach ($model->albums as $album_id => $album) { ?>
						<div class="albums-item" data-id="<?= $album_id ?>">
							<?= $form->field($model, 'albums[' . $album_id . ']')->widget(InputImages::class, [
								'multiple' => true,
								'buttonName' => Yii::t('custompages/page', 'Add photo'),
							])->label(false) ?>
							<div class="albums-item-controls">
								<a href="#" class="btn btn-danger albums-item-remove"><?= Yii::t('custompages/page', 'Remove album'); ?></a>
								<a href="#" class="btn btn-default albums-item-copy-gallery" title="Get gallery shortcode"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[gallery <?= $album_id ?>]</a>
								<a href="#" class="btn btn-info albums-item-copy-slider" title="Get slider shortcode"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[slider <?= $album_id ?>]</a>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="albums-controls">
				<a href="#" class="btn btn-primary albums-controls-add" data-controller="<?= $elfinder_controller_url ?>">Add album</a>
			</div>
			<div class="albums-blank" style="display:none;">
				<div class="albums-item">
					<?= $form->field($model, 'albums[blankid]')->widget(InputImages::class, [
						'multiple' => true,
						'buttonName' => Yii::t('custompages/page', 'Add photo'),
					])->label(false) ?>
					<div class="albums-item-controls">
						<a href="#" class="btn btn-danger albums-item-remove">Remove slider</a>
						<a href="#" class="btn btn-default albums-item-copy-gallery" title="Get gallery shortcode"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[gallery blankid]</a>
						<a href="#" class="btn btn-info albums-item-copy-slider" title="Get slider shortcode"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[slider blankid]</a>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php if (Module::getInstance()->enablePageFields && $model->category !== null) { ?>
		<?php
		$page_fields = json_decode($model->category->pages_fields, true);
		if (is_array($page_fields)) {
            foreach ($page_fields as $page_field) {
				if (isset($page_field['name'], $page_field['type'], $page_field['label'])) {
                    $name = $page_field['name'];
                    $type = $page_field['type'];
                    $label = $page_field['label'];
                    switch ($type) {
                        case 'html':
                            echo $form->field($model, 'fields_data[' . $name . ']')->widget(CKEditor::class, [
                                'editorOptions' => CKEditorHelper::defaultOptions(),
                            ])->label($label);
							break;
                        case 'text':
                            echo $form->field($model, 'fields_data[' . $name . ']')
                                ->textarea(['rows' => 6])
                                ->label($label);
                            break;
                        case 'bool':
                            echo $form->field($model, 'fields_data[' . $name . ']')
                                ->dropDownList(['0' => 'Нет', '1' => 'Да'])
                                ->label($label);
                            break;
                        case 'file':
                            echo $form->field($model, 'fields_data[' . $name . ']')->widget(InputFile::class, [
                                'language' => 'ru',
                                'controller' => $elfinder_controller_path,
                                'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'options' => ['class' => 'form-control'],
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'multiple' => false,      // возможность выбора нескольких файлов
                            ])->label($label);
                            break;
                        case 'image':
                            echo $form->field($model, 'fields_data[' . $name . ']')
                                ->widget(InputImages::class, [
                                    'controller' => $elfinder_controller_path,
                                ])->label($label);
                            break;
                        case 'images':
                            echo $form->field($model, 'fields_data[' . $name . ']')
                                ->widget(InputImages::class, [
                                    'controller' => $elfinder_controller_path,
                                    'multiple' => true,
                                ])->label($label);
                            break;
                        default:
                            echo $form->field($model, 'fields_data[' . $name . ']')
                                ->textInput(['maxlength' => true])
                                ->label($label);
                    }
                }
            }
        }
		?>
	<?php } ?>

    <?= $form->field($model, 'published_at')->widget(DatePicker::class, [
        'language' => Yii::$app->language,
        'template' => '{input}{addon}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
            'clearBtn' => true,
            'todayBtn' => 'linked',
        ],
        'clientEvents' => [
            'clearDate' => 'function (e) {$(e.target).find("input").change();}',
        ],
    ]) ?>

	<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('custompages/common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
