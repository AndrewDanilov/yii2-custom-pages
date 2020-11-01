<?php

use andrewdanilov\helpers\NestedCategoryHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use andrewdanilov\ckeditor\CKEditor;
use andrewdanilov\InputImages\InputImages;
use andrewdanilov\custompages\models\Page;
use andrewdanilov\custompages\models\PageTag;
use andrewdanilov\custompages\models\Category;
use andrewdanilov\custompages\assets\CustomPagesBackendAsset;
use andrewdanilov\custompages\BaseModule as CustomPages;
use andrewdanilov\helpers\CKEditorHelper;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model Page */

CustomPagesBackendAsset::register($this);
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(NestedCategoryHelper::getDropdownTree(Category::find(), 0, 'title'), ['prompt' => Yii::t('custompages/backend/page', 'Without Category')]) ?>

	<?php if (CustomPages::getInstance()->enableTags) { ?>
		<?= $form->field($model, 'tagIds')->widget(Select2::class, [
			'data' => ArrayHelper::map(PageTag::find()->all(), 'id', 'name'),
			'language' => Yii::$app->language,
			'options' => [
				'placeholder' => Yii::t('custompages/backend/page', 'Enter tag name...'),
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
		'editorOptions' => ElFinder::ckeditorOptions('elfinder', CKEditorHelper::defaultOptions()),
	]) ?>

	<?= $form->field($model, 'page_template')->dropDownList(CustomPages::getInstance()->getPagesTemplates(), ['prompt' => Yii::t('custompages/backend/page', 'From category settings / Default')]) ?>

	<?= $form->field($model, 'is_main')->checkbox(['label' => Yii::t('custompages/backend/page', 'Use as main page')]) ?>

	<?php if (CustomPages::getInstance()->enableAlbums) { ?>
		<div class="custom-pages-albums">
			<label class="control-label"><?= Yii::t('custompages/backend/page', 'Albums'); ?></label>
			<div class="albums-list">
				<?php if (is_array($model->albums)) { ?>
					<?php foreach ($model->albums as $album_id => $album) { ?>
						<div class="albums-item" data-id="<?= $album_id ?>">
							<?= $form->field($model, 'albums[' . $album_id . ']')->widget(InputImages::class, [
								'multiple' => true,
								'buttonName' => Yii::t('custompages/backend/page', 'Add photo'),
							])->label(false) ?>
							<div class="albums-item-controls">
								<a href="#" class="btn btn-danger albums-item-remove"><?= Yii::t('custompages/backend/page', 'Remove album'); ?></a>
								<a href="#" class="btn btn-default albums-item-copy-gallery" title="Get gallery shortcode"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[gallery <?= $album_id ?>]</a>
								<a href="#" class="btn btn-info albums-item-copy-slider" title="Get slider shortcode"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[slider <?= $album_id ?>]</a>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="albums-controls">
				<a href="#" class="btn btn-primary albums-controls-add">Add album</a>
			</div>
			<div class="albums-blank" style="display:none;">
				<div class="albums-item">
					<?= $form->field($model, 'albums[blankid]')->widget(InputImages::class, [
						'multiple' => true,
						'buttonName' => Yii::t('custompages/backend/page', 'Add photo'),
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

	<?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('custompages/backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
