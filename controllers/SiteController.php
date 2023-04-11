<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\AddresForm;
use app\models\ShowresForm;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
        return $this->render('index');
    }

    public function actionForm()
    {
        return $this->render('form');
    }

    public function actionHello($message)
    {
        return $this->render('hello',['msg'=>$message]);
    }

    public function actionPolls()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $db = \Yii::$app->db;
        $pollRes = $db->createCommand("SELECT * FROM {{announced_pu_results}} WHERE {{polling_unit_uniqueid}} = 19")->queryAll();
        
        Yii::$app->response->data = $pollRes;
        Yii::$app->end();

    }

    public function actionCates()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $db = \Yii::$app->db;
        $lgaRes = $db->createCommand("SELECT * FROM {{lga}}")->queryAll();

        Yii::$app->response->data = $lgaRes;
        Yii::$app->end();

        /*
            Using The Cord To Return A Json Response---
            @@Yii::$app->response->format = Response::FORMAT_JSON;
            @@Yii::$app->response->data = $pollRes;
            @@Yii::$app->end();

            instead of 
            @@exit(json_encode(["success"=>"poll units", "data"=>$lgaRes]));
            ---
        */
    }
    
    public function actionShowparty()
    {
        return $this->render('showparty');
    }


    public function actionAddres()
    {
        $model = new AddresForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(Yii::$app->request->isAjax){
                $db = \Yii::$app->db;
                $post = Yii::$app->request->post();
                $data = $post['AddresForm'];

                $db->createCommand()->insert('addres', [
                    'party_abbreviation' =>  $data['party_abbreviation'],
                    'party_score' => $data['party_score'],
                    'entered_by_user' => $data['entered_by_user'],
                    'user_ip_address' => $data['user_ip_address'],
                    'date_entered' => $data['date_entered']
                ])->execute();

            } 
            // do something meaningful here about $model ...
            return $this->render('addres', ['model' => $model]);
        } else {
            return $this->render('addres', ['model' => $model]);
        }
        $this->render('addres', ['model' => $model]);
    }

    public function actionShowres()
    {
        return $this->render('showres');
    }

    public function actionShowlga()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $db = \Yii::$app->db;
        if(Yii::$app->request->isAjax){
            $datas = Yii::$app->request->post();
            $selectId = $datas['select'];

            $idResult = $db->createCommand("SELECT {{uniqueid}} FROM {{polling_unit}} WHERE {{polling_unit_id}} = :selectId ")
            ->bindValue('selectId', $selectId)
            ->queryColumn();

            $datares = $db->createCommand("SELECT * FROM {{announced_pu_results}} WHERE {{polling_unit_uniqueid}} IN (".implode(',', $idResult).")")
            ->queryAll();

            Yii::$app->response->data = $datares;
            Yii::$app->end();
            
        } 
        else
        {
            echo "<h1>No Hello </h1>";
        }
    }
}
