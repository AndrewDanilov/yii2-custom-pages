<?php
namespace andrewdanilov\custompages\backend\controllers;

use andrewdanilov\custompages\common\models\Category;
use andrewdanilov\helpers\NestedCategoryHelper;
use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use andrewdanilov\custompages\common\models\Page;
use andrewdanilov\custompages\backend\models\PageSearch;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends BaseController
{
	/**
	 * @inheritDoc
	 */
	public function init()
	{
		parent::init();
		$this->viewPath = '@andrewdanilov/custompages/backend/views/page';
	}

	/**
     * Lists all Page models.
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

        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
	        'tree' => $tree,
        ]);
    }

	/**
	 * Creates a new Page model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param null|int $category_id
	 * @return mixed
	 */
    public function actionCreate($category_id=null)
    {
        $model = new Page();
        $model->category_id = $category_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'PageSearch' => ['category_id' => $model->category_id]]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'PageSearch' => ['category_id' => $model->category_id]]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
