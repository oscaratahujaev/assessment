<?php

namespace app\controllers;

use app\components\Functions;
use app\components\MathExpression;
use app\models\Category;
use app\models\CategoryDataSearch;
use app\models\Data;
use app\models\ParamType;
use app\models\Quarter;
use app\models\Region;
use app\models\Score;
use app\models\Years;
use Yii;
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
        $category = Category::find()->with('categoryParams')->where(['id' => $categoryId ? $categoryId : 1])->asArray()->one();
        $post = Yii::$app->request->post();
        $datas = [];
        $year = $year ? $year : 2018;
        $scoreVariable = 0;
        if ($post) {
            $i = 3;

            foreach ($category['categoryParams'] as $param) {
                $data = new Data();
                $data->category_id = $categoryId;
                $data->region_id = $regionId;
                $data->district_id = $request->getBodyParam("districtId");
                $data->param_id = $param['id'];
                $data->year = $year;
                $data->quarter = $quarter ? $quarter : Quarter::find()->one()->id;
                if ($param['param_type_id'] == ParamType::TYPE_INPUT) {
                    $data->value = $post[$i++];
                } else if ($param['param_type_id'] == ParamType::TYPE_FORMULA) {
                    $formula = $param['formula'];
                    $expr = new MathExpression($formula, $post);
                    $expr->calculate();
                    $data->value = $expr->getResult();
                    $scoreVariable = $data->value;
                    $score = new Score();
                    $score->category_id = $categoryId;
                    $score->region_id = $regionId;
                    $score->district_id = $request->getBodyParam('districtId');
                    $score->year = $year;
                    $score->quarter_id = $quarter ? $quarter : Quarter::find()->one()->id;
                    $score->value = $expr->getScore($scoreVariable);
                    if ($score->save()) {
                    } else {
                        var_dump($score->getErrors());
                    }
                }
                $data->save();
            }

            return $this->redirect('/data/index');
        } else {
            $i = 0;
            foreach ($category['categoryParams'] as $param) {
                if ($param['param_type_id'] == 1) {
                    $model = new Data();
                    $model->category_id = $categoryId;
                    $model->region_id = $regionId;
                    $model->district_id = 1;
                    $model->param_id = $param['id'];
                    $model->param->name = $param['name'];
                    $datas[$i] = $model;
                    $i++;
                }
            }
        }
        return $this->render('add', [
            'data' => $datas,
            'category' => $category,
            'region_id' => $regionId,
        ]);
    }


    public function actionTable()
    {
        $request = Yii::$app->request;
        $categoryId = $request->getQueryParam('categoryID') ? $request->getQueryParam('categoryID') : 1;
        $regionId = $request->getQueryParam('regionID');
        $yearId = $request->getQueryParam('yearID') ? $request->getQueryParam('yearID') : Years::find()->one()->year;
        $quarterId = $request->getQueryParam('quarterID');
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
            $query->andWhere(['district_id' => null]);
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

        return $this->render('table', [
            'categoryId' => $categoryId,
            'regionId' => $regionId,
            'yearId' => $yearId,
            'quarterId' => $quarterId,
            'data' => $arr,
            'category' => $category,
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
