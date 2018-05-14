<?php

namespace app\controllers;

use app\components\Functions;
use app\components\MathExpression;
use app\models\Category;
use app\models\CategoryDataSearch;
use app\models\CategoryParams;
use app\models\Data;
use app\models\District;
use app\models\ParamType;
use app\models\Quarter;
use app\models\Region;
use app\models\Score;
use app\models\Years;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DataController implements the CRUD actions for Data model.
 */
class DataController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Data models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoryDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionAdd($categoryId = 1, $regionId = 1, $districtId = null, $yearId = 2018, $quarterId = 1)
    {
        $request = Yii::$app->request;

        $category = Category::find()->with('categoryParams')->where(['id' => $categoryId])->asArray()->one();

        $post = $request->post();

        if ($post) {

            if (Data::setData($category, $post) && Score::setScore($post)) {

                return $this->redirect(['table',
                    'categoryId' => $categoryId,
                    'regionId' => $regionId,
                    'year' => $yearId,
                    'quarter' => $quarterId,
                ]);
            }
        }

        $i = 3;
        $data = [];
        foreach ($category['categoryParams'] as $param) {
            if ($param['param_type_id'] == ParamType::TYPE_INPUT) {
                $model = new Data();
                $model->category_id = $categoryId;
                $model->region_id = $regionId;
                $model->district_id = 1;
                $model->param_id = $param['id'];
                $model->param->name = $param['name'];
                $data[$i] = $model;
            }

            if (in_array($param['param_type_id'], [ParamType::TYPE_INPUT, ParamType::TYPE_FORMULA])) {
                $i++;
            }
        }

        return $this->render('add', [
            'data' => $data,
            'category' => $category,
            'region_id' => $regionId,
            'districtId' => $districtId,
        ]);
    }

    public static function getData($categoryId, $regionId, $yearId, $quarterId)
    {

        $category = Category::find()->with('categoryParams')->where(['id' => $categoryId])->asArray()->one();
        $data = [];


        //needed for finding the number of districts of a region

        $numberOfChildDistricts = 0;
        $query = Data::find()
            ->where(['category_id' => $categoryId])
            ->andWhere(['year' => $yearId])
            ->andWhere(['quarter' => $quarterId]);
        if (!empty($regionId)) {
            $query->andWhere(['region_id' => $regionId]);
            $query->andWhere(['<>', 'district_id', '']);
            $query->with('district');
            $query->with('scoreDistrict');
            $query->with('param');
        } else {
            $query->select(['*, sum(value) as value']);
            $query->with('region');
            $query->with('category');
            $query->with('param');
            $query->groupBy('region_id, param_id');
        }
        $numberOfChildDistricts = 0;

        $data = $query
            ->orderBy('param_id ASC')
            ->asArray()
            ->all();
        $arr = [];

        if ($regionId) {
            foreach ($data as $item) {
                $arr[$item['district_id']]['place'] = $item['district'] ? $item['district']['name'] : '';
                $arr[$item['district_id']]['values'][] = $item;
                $arr[$item['district_id']]['score'] = $item['scoreDistrict'] ? $item ['scoreDistrict']['value'] : '';
            }
        } else {
            foreach ($data as $item) {
                $arr[$item['region_id']]['place'] = $item['region'] ? $item['region']['name'] : '';
                $arr[$item['region_id']]['values'][] = $item;
                //                $arr[$item['region_id']]['score'] = $item['scoreRegion'] ? $item ['scoreRegion']['value'] : '';
            }
        }


        $filledDistricts = [];
        $emptyPlaces = [];
        if (isset($regionId)) {
            foreach ($arr as $key => $item) {
                array_push($filledDistricts, $item['place']);
            }
            $emptyPlaces = District::find()->where(['region_id' => $regionId])->andWhere(['NOT IN', 'name', $filledDistricts])->orderBy('name asc')->all();
        } else {
            $emptyPlaces = Region::find()->where(['NOT IN', 'name', $filledDistricts])->asArray()->all();
        }

//                debug($emptyPlaces);
//                exit;

        return [
            'data' => $arr,
            'emptyPlaces' => $emptyPlaces,
            'category' => $category,
        ];
    }


    public function actionStatistics($categoryId = 1, $regionId = null, $yearId = 2018, $quarterId = 1)
    {

        return $this->render('statistics',
            array_merge(self::getData($categoryId, $regionId, $yearId, $quarterId),
                [
                    'categoryId' => $categoryId,
                    'regionId' => $regionId,
                    'yearId' => $yearId,
                    'quarterId' => $quarterId,
                ]));
    }


    public function actionTable($categoryId = 1, $regionId = 1, $yearId = 2018, $quarterId = 1)
    {

        return $this->render('table',
            array_merge(self::getData($categoryId, $regionId, $yearId, $quarterId),
                [
                    'categoryId' => $categoryId,
                    'regionId' => $regionId,
                    'yearId' => $yearId,
                    'quarterId' => $quarterId,
                ]));

    }


    /**
     * Displays a single Data model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public
    function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Data model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public
    function actionCreate()
    {
        $model = new Data();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Data model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public
    function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Data model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public
    function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Data model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Data the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = Data::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
