<?php

namespace app\controllers;
use yii\web\Controller;

class DaoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actionAll()
    {
        $conn = \Yii::$app->db;
        $sql = "select * from country";
        $command =$conn->createCommand($sql);
        $data = $command->queryOne();
        return  $res=json_encode($data);

    }
}
