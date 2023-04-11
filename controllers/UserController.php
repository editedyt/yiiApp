<?php

namespace app\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use app\models;

class UserController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionPolls()
    {
        $db = \Yii::$app->db;
        $pollRes = $db->createCommand("SELECT * FROM {{announced_pu_results}} WHERE {{polling_unit_uniqueid}} = 19")->queryAll();
        exit(json_encode(["success"=>"poll units", "data"=>$pollRes]));
    }
    public function actionCates()
    {
        $db = \Yii::$app->db;
        $lgaRes = $db->createCommand("SELECT * FROM {{lga}}")->queryAll();
        exit(json_encode(["success"=>"poll units", "data"=>$lgaRes]));
    }

    public function actionAjaxRequest(){
        // echo Yii::$app->request->baseUrl;
		if(Yii::$app->request->isAjax){

			$data= Yii::$app->request->post();
            print_r($data);
		} 
        // if(isset($_POST)){
        //     $data= Yii::$app->request->post();;
        //     var_dump($data);
        // } else {
        //     echo "no";
        // }
	}
    
    public function actionRequest(){
			$data = Yii::$app->request->getBodyParams();
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
	}

    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // valid data received in $model

            // do something meaningful here about $model ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('entry', ['model' => $model]);
        }
    }
}