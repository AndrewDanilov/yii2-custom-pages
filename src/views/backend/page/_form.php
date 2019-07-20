<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use sadovojav\ckeditor\CKEditor;
use dosamigos\datepicker\DatePicker;
use andrewdanilov\InputImages\InputImages;
use andrewdanilov\common\models\Page;
use andrewdanilov\common\models\Category;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model Page */

?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getCategoriesList()) ?>

	<?= $form->field($model, 'image')->widget(InputImages::class) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	<?php
	$editorOptions = ElFinder::ckeditorOptions('elfinder', [
		'toolbar' => [
			['Source', 'NewPage', 'Preview', 'Viewss'],
			['PasteText', '-', 'Undo', 'Redo'],
			['Replace', 'SelectAll', 'Scayt'],
			['Format', 'FontSize'],
			['Bold', 'Italic', 'Underline', 'TextColor', 'StrikeThrough', '-', 'Outdent', 'Indent', 'RemoveFormat', 'Blockquote', 'HorizontalRule'],
			['NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
			['Image', 'oembed', 'Video', 'Iframe'],
			['Link', 'Unlink'],
			['Maximize', 'ShowBlocks'],
		],
		'allowedContent' => true,
		'forcePasteAsPlainText' => true,
		'extraPlugins' => 'image2,widget,oembed,video',
		'language' => Yii::$app->language,
		'height' => 500,
	]);
	?>
	<?= $form->field($model, 'text')->widget(CKEditor::class, [
		'editorOptions' => $editorOptions,
	]) ?>

	<?= $form->field($model, 'published_at')->widget(DatePicker::class, [
		'language' => 'ru',
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

	<?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
