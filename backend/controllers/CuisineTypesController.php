<?php

namespace backend\controllers;

use backend\components\Helpers;
use common\models\CuisineTypesAssn;
use Yii;
use common\models\CuisineTypes;
use backend\models\search\CuisineTypesSearch;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * CuisineTypesController implements the CRUD actions for CuisineTypes model.
 */
class CuisineTypesController extends BackendController
{

    /**
     * Lists all CuisineTypes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CuisineTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
           'tags' => CuisineTypes::find()->select('title')->indexBy('id')->orderBy('title')->column(),
           'tagsWithoutCategory' => CuisineTypes::find()->select('cuisine_types.title,')->leftJoin(CuisineTypesAssn::tableName(),'cuisine_types_assn.tag_id = cuisine_types.id')->where('cuisine_types_assn.tag_id IS NULL')->asArray()->all()
        ]);
    }

    /**
     * Creates a new CuisineTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CuisineTypes();
        if (Yii::$app->request->post('CuisineTypes')) {
            $category = CuisineTypes::findOne(['code_api' => Yii::$app->request->post('CuisineTypes')['title']]);
            if ($category != null) {
                $category->updateAttributes(['category' => CuisineTypes::CATEGORY_MAIN]);
                $this->setMessage(true);
                return $this->redirect(['update', 'id' => $category->id]);
            }
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->category = CuisineTypes::CATEGORY_MAIN;
            $model->status = CuisineTypes::STATUS_ACTIVE;
            $model->code_api = strtolower($model->title);
            if ($model->save()) {
                $this->setMessage(true);
                return $this->redirect(['update', 'id' => $model->id]);
            }else {
                $this->setMessage(false);
            }
        }
        return $this->render('create', [
           'model' => $model,
        ]);
    }

    /**
     * Updates an existing CuisineTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param bool $alert
     * @return mixed
     */
    public function actionUpdate($id,$alert = false)
    {
        $model = $this->findModel($id);
        $types = CuisineTypes::find()->indexBy('id')->orderBy('title')->all();
        $typesAssn = ArrayHelper::map(CuisineTypesAssn::findAll(['type_id' => $id]),'tag_id','tag_id');

        if ($model->load(Yii::$app->request->post())) {
            $this->setMessage($model->save());
        }

        if($alert){
            $this->setMessage(true);
        }

        return $this->render('update', [
           'model' => $model,
           'types' => $types,
           'typesAssn' => $typesAssn
        ]);

    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        CuisineTypesAssn::deleteAll(['type_id' => $id]);
        $this->setMessage($model->updateAttributes(['category' => CuisineTypes::CATEGORY_TAG]));
        return $this->redirect(['index']);
    }

    /**
     * Finds the CuisineTypes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CuisineTypes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CuisineTypes::find()->where(['id' => (int)$id, 'category' => CuisineTypes::CATEGORY_MAIN])->one()) !== null) {
            return $model;
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @param $status
     * @return \yii\web\Response
     */
    public function actionSetStatus($id, $status)
    {
        if (!empty($id) && isset($status)) {
            $model = $this->findModel($id);
            if ($model !== null) {
                $model->status = (int)$status;
                $this->setMessage($model->save());
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCategoryAssn(){
        if(Yii::$app->request->isPost){
            $ids = Yii::$app->request->post('ids',[]);
            $category = Yii::$app->request->post('category',null);
            return Helpers::categoryTagsAssn($category,$ids);

        }
        return false;
    }
}
