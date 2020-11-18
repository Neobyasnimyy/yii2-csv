<?php

namespace app\controllers;

use app\models\Categories;
use app\models\People;
use app\models\PeopleSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
     * Displays homepage.
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

//        echo '<pre>';
//        var_dump(Yii::$app->request->queryParams);
//        echo '</pre>';
//        exit();

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
                    "Успешно добавленна $count_new_categories новая категория.");
            }
            if ($count_new_people = People::saveManyPeople($model->data)) {
                Yii::$app->session->setFlash('success',
                    "Успешно добавленна $count_new_people строки в таблицу People.");
            }
        } else {
            Yii::$app->session->setFlash('error', "Ошибка загрузки файла.");
        }
        return $this->goHome();
    }


}
