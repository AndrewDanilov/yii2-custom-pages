<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use sadovojav\ckeditor\CKEditor;
use andrewdanilov\custompages\Module as CustomPages;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model andrewdanilov\custompages\models\Category */

?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

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

    <?= $form->field($model, 'category_template')->dropDownList(CustomPages::getInstance()->getCategoryTemplates()) ?>

    <?= $form->field($model, 'pages_template')->dropDownList(CustomPages::getInstance()->getPagesTemplates()) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
