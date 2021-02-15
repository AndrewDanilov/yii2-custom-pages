<?php
namespace andrewdanilov\custompages\backend\controllers;

use andrewdanilov\custompages\common\models\Category;
use andrewdanilov\custompages\common\models\Page;
use andrewdanilov\helpers\NestedCategoryHelper;
use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BaseController
{
	/**
	 * @inheritDoc
	 */
	public function init()
	{
		parent::init();
		$this->viewPath = '@andrewdanilov/custompages/backend/views/category';
	}

	/**
	 * Lists all Category models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$pages_query = (new Query())
			->select('COUNT(*)')
			->from(Page::tableName())
			->where(Page::tableName() . '.category_id = ' . Category::tableName() . '.id');
		$categories_query = Category::find()
			->select([
				Category::tableName() . '.id',
				Category::tableName() . '.parent_id',
				Category::tableName() . '.title',
				'count' => $pages_query,
			])
			->orderBy(['order' => SORT_ASC]);
		$tree = NestedCategoryHelper::getPlaneTree($categories_query);

		return $this->render('index', [
			'tree' => $tree,
		]);
	}

	/**
	 * Creates a new Category model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param null|int $parent_id
	 * @return mixed
	 */
	public function actionCreate($parent_id=null)
	{
		$model = new Category();
		$model->parent_id = $parent_id;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index']);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Category model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index']);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Category model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Category model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Category the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Category::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
