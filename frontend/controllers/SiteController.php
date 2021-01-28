<?php

namespace frontend\controllers;

use common\models\ClickThrough;
use common\models\Page;
use common\models\Restaurant;
use frontend\models\ProfileForm;
use frontend\models\search\RestaurantSearch;
use frontend\services\googlePlacesApi\GooglePlaceSearch;
use frontend\services\googlePlacesApi\RestaurantDetails;
use frontend\services\SearchCuisineAndRestaurants;
use frontend\services\Services;
use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
           'error' => [
              'class' => 'yii\web\ErrorAction',
           ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionLocation($suburb = null)
    {

        if (!empty($suburb)) {
            $model = Yii::$app->user->identity;
            $model->suburb_id = (int)$suburb;
            if ($model->save()) {
                return $this->redirect('index');
            }
        }

        if (Yii::$app->request->isPost) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return Services::checkSuburb(Yii::$app->request->post());
        }

        return $this->render('location');
    }

    public function actionIndex($category = 'all',$type = null)
    {
        if (!Yii::$app->user->identity->suburb_id) {
            $this->redirect('location');
        }
        $searchModel = new RestaurantSearch();
        $searchModel->setSort(Yii::$app->request->post());
        if (Yii::$app->request->isPost) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        $searchModel->category = $category;
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        Url::remember();
        $typeTitle = empty($searchModel->type) ? $category : 'filtered';

        if (Yii::$app->request->isAjax) {
            return $this->render('index', [
               'dataProvider' => $dataProvider,
               'cuisineTitle' => Services::cuisineTitle($typeTitle),
               'count' => $searchModel->count ?? 0,
               'favorites' => Services::getFavorites(),
               'cuisineList' => Services::cuisineTypes(),
               'suburbTitle' => [],
               'category' => $category,
               'sort' => $searchModel->sort
            ]);
        }

        return $this->render('index', [
           'dataProvider' => $dataProvider,
           'suburbTitle' => Services::suburbTitle(),
           'cuisineTitle' => Services::cuisineTitle($typeTitle),
           'cuisineList' => Services::cuisineTypes(),
           'count' => $searchModel->count ?? 0,
           'favorites' => Services::getFavorites(),
           'category' => $category,
           'sort' => $searchModel->sort
        ]);
    }

    /**
     * @return array|string
     */
    public function actionSearch()
    {
        if (Yii::$app->request->isPost && !empty(Yii::$app->request->post('s'))) {
            $string = trim(strip_tags(Yii::$app->request->post('s',false)));
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return (new SearchCuisineAndRestaurants())->search($string);
        }
        return $this->render('search');
    }

    public function actionFavorite()
    {
        if (Yii::$app->request->isPost) {
            return Services::setFavorites(Yii::$app->request->post('id', false));
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCheckSuburb()
    {
        $this->enableCsrfValidation = true;
        if (Yii::$app->request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return Services::checkSuburb(Yii::$app->request->post());
        }
    }

    public function actionSaveClick()
    {
        if (!empty(Yii::$app->request->post('id'))) {
            ClickThrough::addClick(Yii::$app->request->post('id'));
        }
    }

    public function actionRestaurantDetails(int $id)
    {

        $model = Restaurant::find()->where(['id' => $id])->limit(1)->with(['state', 'deliveries.platform', 'favoriteWithUser'])->one();
        if ($model == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $details = (new RestaurantDetails())->getDetails($model);

        return $this->render('restaurant-details', [
           'model' => $model,
           'details' => $details,
           'return' => Url::previous(),
           'images' => $model->imagesConfirmed
        ]);
    }
}
