<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use sadovojav\ckeditor\CKEditor;
use dosamigos\datepicker\DatePicker;
use andrewdanilov\InputImages\InputImages;
use andrewdanilov\custompages\models\Page;
use andrewdanilov\custompages\models\Category;
use andrewdanilov\gridtools\helpers\CKEditorHelper;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model Page */

?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getCategoriesList()) ?>

	<?= $form->field($model, 'image')->widget(InputImages::class) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'text')->widget(CKEditor::class, [
		'editorOptions' => ElFinder::ckeditorOptions('elfinder', CKEditorHelper::defaultOptions()),
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
