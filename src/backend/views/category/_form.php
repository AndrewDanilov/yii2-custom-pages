<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use andrewdanilov\ckeditor\CKEditor;
use andrewdanilov\custompages\backend\Module;
use andrewdanilov\custompages\common\models\Category;
use andrewdanilov\helpers\CKEditorHelper;
use andrewdanilov\helpers\NestedCategoryHelper;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model Category */

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

	<?= $form->field($model, 'parent_id')->dropDownList(NestedCategoryHelper::getDropdownTree(Category::find(), 0, 'title'), ['prompt' => 'Верхний уровень', 'style' => 'font-family:monospace;']) ?>

	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'menu_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'text')->widget(CKEditor::class, [
		'editorOptions' => ElFinder::ckeditorOptions($elfinder_controller_path, CKEditorHelper::defaultOptions()),
	]) ?>

    <?= $form->field($model, 'category_template')->dropDownList(Module::getInstance()->getCategoryTemplates()) ?>

    <?= $form->field($model, 'pages_template')->dropDownList(Module::getInstance()->getPagesTemplates()) ?>

    <?php if (Module::getInstance()->enablePageFields) { ?>
        <?= $form->field($model, 'pages_fields', ['template' => "{label}\n{hint}\n{input}\n{error}"])->textarea(['rows' => 5])->hint(Yii::t('custompages/category', 'Example: [{"name": "field1", "type": "string", "label": "String Field 1"}, {"name": "field2", "type": "text", "label": "Text Field 2"}]<br>You can use types: string, text, html, bool, file, image, images'), ['style' => 'color:#bbb;']) ?>
    <?php } ?>

    <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('custompages/common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
