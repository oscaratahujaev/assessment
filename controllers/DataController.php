<?php

namespace app\controllers;

use app\components\Functions;
use app\components\MathExpression;
use app\models\Category;
use app\models\CategoryDataSearch;
use app\models\CategoryParams;
use app\models\Data;
use app\models\DataStatus;
use app\models\District;
use app\models\ParamType;
use app\models\Quarter;
use app\models\Region;
use app\models\Score;
use app\models\User;
use app\models\Years;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['statistics'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => User::can(User::USER_SIMPLE),
                        'roles' => ['@'],
                    ],
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


    public function actionAdd($categoryId = 1, $regionId = 1, $districtId, $yearId = 2018, $quarterId = 1)
    {
        $request = Yii::$app->request;

        $category = Category::find()->with('categoryParams')->where(['id' => $categoryId])->asArray()->one();

        $post = $request->post();

        if ($post) {

            if (Data::setData($category, $post) && Score::setScore($post)) {

                return $this->redirect(['table',
                    'category' => $category,
                    'categoryId' => $categoryId,
                    'year' => $yearId,
                    'quarter' => $quarterId,
                    'regionId' => $regionId,
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
                $model->district_id = $districtId;
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

    public function actionUpdate($categoryId, $regionId, $districtId, $yearId, $quarterId)
    {
        $request = Yii::$app->request;
        $category = Category::find()->with('categoryParams')->where(['id' => $categoryId])->asArray()->one();

        $post = $request->post();

        if ($post) {

//            if (Data::updateData($category, $post) && Score::updateScore($post)) {

                return $this->redirect(['table',
                    'category' => $category,
                    'categoryId' => $categoryId,
                    'year' => $yearId,
                    'quarter' => $quarterId,
                    'regionId' => $regionId,
                ]);
//            }
        }

        $arr = Data::find()
            ->from('data d')
            ->leftJoin('category_params p', 'd.param_id=p.id')
            ->where([
                'region_id' => $regionId,
                'district_id' => $districtId,
                'd.category_id' => $categoryId,
                'year' => $yearId,
                'quarter' => $quarterId,
                'p.param_type_id' => 1
            ])
            ->all();
        if (empty($arr)) {
            return $this->goHome();
        }
        $data = [];
        foreach ($arr as $key => $item) {
            $data[$key + 3] = $item;
        }
//        debug($data);
//        exit;

        //        $i = 3;
        //        $data = [];
        //        foreach ($category['categoryParams'] as $param) {
        //            if ($param['param_type_id'] == ParamType::TYPE_INPUT) {
        //                $model = new Data();
        //                $model->category_id = $categoryId;
        //                $model->region_id = $regionId;
        //                $model->district_id = $districtId;
        //                $model->param_id = $param['id'];
        //                $model->param->name = $param['name'];
        //                $data[$i] = $model;
        //            }
        //
        //            if (in_array($param['param_type_id'], [ParamType::TYPE_INPUT, ParamType::TYPE_FORMULA])) {
        //                $i++;
        //            }
        //        }

        return $this->render('update', [
            'data' => $data,
            'category' => $category,
            'region_id' => $regionId,
            'districtId' => $districtId,
        ]);


    }

    public function actionLoadFile($id)
    {
        $model = DataStatus::findOne($id);
        if (empty($model)) {
            return $this->goHome();
        }
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Transfer-Encoding: binary');
        header('Content-length: ' . $model->filesize);
        header('Content-Type: ' . $model->filetype);
        header('Content-Disposition: attachment; filename=' . $model->filename);

        echo $model->file;
    }

    public function actionSendForApprovement($id)
    {
        $model = DataStatus::findOne($id);
        if (empty($model)) {
            return $this->goHome();
        }

    }

    public function actionFileUpload($categoryId, $year, $quarter)
    {
        $dataStatus = DataStatus::findOne([
            'category_id' => $categoryId,
            'year' => $year,
            'quarter' => $quarter,
        ]);
        if (empty($dataStatus)) {
            $dataStatus = new DataStatus();
            $dataStatus->category_id = $categoryId;
            $dataStatus->year = $year;
            $dataStatus->quarter = $quarter;
        }

        if ($dataStatus->load(Yii::$app->request->post()) && $dataStatus->save()) {
            return $this->redirect(['table',
                'categoryId' => $categoryId,
                'year' => $year,
                'quarterId' => $quarter
            ]);
        }

        return $this->render('file-upload', [
            'model' => $dataStatus
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
                $arr[$item['district_id']]['id'] = $item['district'] ? $item['district']['id'] : '';
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
        if ($regionId != "") {
            foreach ($arr as $item) {
                array_push($filledDistricts, $item['place']);
            }
            $emptyPlaces = District::find()->where(['region_id' => $regionId])->andWhere(['NOT IN', 'name', $filledDistricts])->all();
        } else {
            $emptyPlaces = Region::find()->where(['NOT IN', 'name', $filledDistricts])->all();
        }

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


    public function actionTable($categoryId = 1, $regionId = 1, $year = 2018, $quarterId = 1)
    {
        return $this->render('table',
            array_merge(self::getData($categoryId, $regionId, $year, $quarterId),
                [
                    'categoryId' => $categoryId,
                    'regionId' => $regionId,
                    'yearId' => $year,
                    'quarterId' => $quarterId,
                ]));

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
