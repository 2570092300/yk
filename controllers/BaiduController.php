<?php

namespace app\controllers;

use yii;
use yii\web\Controller;

class BaiduController extends Controller
{
    public function actionIndex()
    {
        $name = "石家庄";
        $res = file_get_contents("http://api.map.baidu.com/geocoding/v3/?address=$name&output=json&ak=3RHVtTn06hrWX0yVzpCEhc2kCWoxy5jS");

        $data = json_decode($res, true);

        $lng = $data['result']['location']['lng'];
        $lat = $data['result']['location']['lat'];


        return $this->render('index', ['lng' => $lng, 'lat' => $lat]);
    }
}
