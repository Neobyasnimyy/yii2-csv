<?php

namespace app\controllers;

use app\models\Categories;
use app\models\People;
use app\models\PeopleSearch;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\UploadCsv;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage and search people
     *
     * @return string
     */
    public function actionIndex()
    {
        $modelUploadCsv = new UploadCsv();
        $searchModelPeople = new PeopleSearch();
        $dataProviderPeople = $searchModelPeople->search(
            Yii::$app->request->queryParams
        );
        $categories = Categories::getCategories();

        return $this->render(
            'index', [
                'modelUploadCsv' => $modelUploadCsv,
                'searchModelPeople' => $searchModelPeople,
                'dataProviderPeople' => $dataProviderPeople,
                'categories' => $categories
            ]
        );
    }

    /**
     * action upload csv
     *
     * @return Response
     * @throws \yii\db\Exception
     */
    public function actionUpload()
    {
        $model = new UploadCsv();
        $model->uploadedFile = UploadedFile::getInstance($model, 'uploadedFile');
        if ($model->setData()) {
            // file is uploaded successfully
            if ($count_new_categories = Categories::saveManyCategories($model->new_categories)) {
                Yii::$app->session->setFlash('success',
                    "Added $count_new_categories new categories successfully  .");
            }
            if ($count_new_people = People::saveManyPeople($model->data)) {
                Yii::$app->session->setFlash('success',
                    "Successfully added $count_new_people rows to People table .");
            }
        } else {
            Yii::$app->session->setFlash('error', "File upload error.");
        }
        return $this->goHome();
    }


}
