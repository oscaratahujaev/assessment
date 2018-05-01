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


    public function actionAdd()
    {
        $request = Yii::$app->request;
        $categoryId = $request->getQueryParam("categoryID");
        $regionId = $request->getQueryParam("regionID");
        $year = $request->getQueryParam("year");
        $quarter = $request->getQueryParam("quarter");
        $category = Category::find()->with('categoryParams')->where(['id' => $categoryId])->asArray()->one();
        $post = Yii::$app->request->post();

        $scoreVariable = 0;

        if ($post) {
            Data::setData($category, $post);
            if (Score::setScore($post)) {
                return $this->redirect(['table',
                    'category' => $category,
                    'categoryID' => $categoryId,
                    'year' => $year,
                    'quarter' => $quarter,
                    'regionID' => $regionId,
                ]);
            }

        } else {

            $i = 3;
            $datas = [];
            foreach ($category['categoryParams'] as $param) {
                if ($param['param_type_id'] == ParamType::TYPE_INPUT) {
                    $model = new Data();
                    $model->category_id = $categoryId;
                    $model->region_id = $regionId;
                    $model->district_id = $request->get('districtID');
                    $model->param_id = $param['id'];
                    $model->param->name = $param['name'];
                    $datas[$i] = $model;
                }

                if (in_array($param['param_type_id'], [ParamType::TYPE_INPUT, ParamType::TYPE_FORMULA])) {
                    $i++;
                }
            }
        }
        return $this->render('add', [
            'data' => $datas,
            'category' => $category,
            'region_id' => $regionId,
            'districtId' => $request->get('districtID'),
        ]);
    }


    public function actionTable()
    {
        $request = Yii::$app->request;

        $categoryId = $request->get('categoryID');
        $regionId = $request->get('regionID');
        $yearId = $request->get('yearID');
        $quarterId = $request->get('quarterID');


        $category = Category::find()->with('categoryParams')->where(['id' => $categoryId])->asArray()->one();

        $data = [];
        $query = Data::find()
            ->where(['category_id' => $categoryId])
            ->andWhere(['year' => $yearId])
            ->andWhere(['quarter' => $quarterId]);
        if (isset($regionId)) {
            $query->andWhere(['region_id' => $regionId]);
            $query->andWhere(['<>', 'district_id', '']);
            $query->with('district');
            $query->with('scoreDistrict');
        } else {
            $query->andWhere(['district_id' => '']);
            $query->with('region');
            $query->with('scoreRegion');
        }
        $data = $query
            ->orderBy('param_id ASC')
            ->asArray()
            ->all();

        $arr = [];
        if ($regionId) {
            foreach ($data as $item) {
                $arr[$item['district_id']]['place'] = $item['district'] ? $item['district']['name'] : '';
                $arr[$item['district_id']]['values'][] = $item['value'];
                $arr[$item['district_id']]['score'] = $item['scoreDistrict'] ? $item ['scoreDistrict']['value'] : '';
            }
        } else {
            foreach ($data as $item) {
                $arr[$item['region_id']]['place'] = $item['region'] ? $item['region']['name'] : '';
                $arr[$item['region_id']]['values'][] = $item['value'];
                $arr[$item['region_id']]['score'] = $item['scoreRegion'] ? $item ['scoreRegion']['value'] : '';
            }
        }

        $filledDistricts = [];
        $emptyPlaces = [];
        if (isset($regionId)) {
            foreach ($arr as $item) {
                array_push($filledDistricts, $item['place']);
            }
            $emptyPlaces = District::find()->where(['region_id' => $regionId])->andWhere(['NOT IN', 'name', $filledDistricts])->all();
        } else {
            $emptyPlaces = Region::find()->where(['NOT IN', 'name', $filledDistricts])->all();
        }
        return $this->render('table', [
            'categoryId' => $categoryId,
            'regionId' => $regionId,
            'yearId' => $yearId,
            'quarterId' => $quarterId,
            'data' => $arr,
            'category' => $category,
            'emptyPlaces' => $emptyPlaces
        ]);

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
