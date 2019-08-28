<?php

namespace app\controllers;

use yii;
use yii\web\Controller;

class TestController extends Controller
{
    /**
     * 注册功能
     *
     * @return void
     */
    public function actionRegister()
    {
        return $this->render('register');
    }

    /**
     * 注册入库
     *
     * @return void
     * 成功展示信息
     * 失败重新注册
     */
    public function actionRegister_do()
    {
        $connection = \Yii::$app->db;
        $arr = Yii::$app->request->post();

        $res = $connection->createCommand()->insert('user', [
            'name' => $arr['name'],
            'pwd' => $arr['pwd'],
            'phone' => $arr['phone'],
        ])->execute();

        if ($res) {
            return $this->render('register_do', ['data' => $arr]);
        } else {
            return $this->render('register');
        }
    }

    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionLogin_do()
    {
        $arr = Yii::$app->request->post();
        $rows = (new \yii\db\Query())
            ->from('user')
            ->where(['name' => $arr['name']])
            ->where(['pwd' => $arr['pwd']])
            ->limit(1)
            ->all();

        if ($rows) {
            return $this->render('list');
        } else {
            return $this->render('login');
        }
    }

    public function actionLogin_phone()
    {
        return $this->render('login_phone');
    }

    public function actionLogin_phone_do()
    {
        $arr = Yii::$app->request->post();
        $rows = (new \yii\db\Query())
            ->from('user')
            ->where(['phone' => $arr['phone']])
            ->limit(1)
            ->all();

        if ($rows) {
            return $this->actionList();
        } else {
            return $this->render('login');
        }
    }

    public function actionList()
    {
        return $this->render('list');
    }

    public function actionLists($row = '')
    {
        $rows = (new \yii\db\Query())
            ->from('user')
            ->all();

        if (!empty($row)) {
            return json_encode(['code' => '0', 'msg' => '查询成功', 'data' => $row]);
            die;
        } else {
            if ($rows) {
                return json_encode(['code' => '0', 'msg' => '查询成功', 'data' => $rows]);
            } else {
                return json_encode(['code' => '1', 'msg' => '查询失败']);
            }
        }
    }

    public function actionSearch()
    {
        $arr = Yii::$app->request->post();

        $rows = (new \yii\db\Query())
            ->from('user')
            ->andWhere(['like', 'name', $arr['name']])
            ->all();
        $row = json_encode(['code' => '0', 'msg' => '查询成功', 'data' => $rows]);
        $this->actionLists($row);

        if ($rows) {
            return $this->actionList();
        } else {
            return $this->render('list');
        }
    }

    public function actionExeclr()
    {
        $arr = file_get_contents("cs.xls");
        $data = explode("\n", $arr);

        foreach ($data as $key => $value) {
            $res[] = explode("\t", $value);
        }
        unset($res[0]);
        // unset($res[15]);
        $connection = \Yii::$app->db;
        foreach ($res as $key => $value) {
            $connection->createCommand()->insert('user', [
                'name' => $value[1],
                'pwd' => $value[2],
                'phone' => $value[3],
            ])->execute();
        }
    }

    public function actionExeclc()
    {
        $rows = (new \yii\db\Query())
            ->from('user')
            ->all();

        $str = "id \t 用户名 \t 密码 \t 手机号\n";

        foreach ($rows as $key => $value) {
            $str .= implode("\t", $value) . "\n";
        }

        $ip = $_SERVER['SERVER_ADDR'];
        $name = "管理员";
        $desc = "导出";

        $connection = \Yii::$app->db;

        $connection->createCommand()->insert('log', [
            'name' => $name,
            'ip' => $ip,
            'desc' => $desc,
        ])->execute();

        header('Content-type: application/vnd.ms-execl');

        header('Content-Disposition: attachment; filename="员工工资详情.xls"');

        echo $str;
    }

    public function actionElist()
    {
        return $this->render('elist');
    }

    public function actionEsearch()
    {
        $arr = Yii::$app->request->post();

        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);

        if ($redis->hExists('data', 'name')) {
            $rows = $redis->hGet('name');
        } else {
            $rows = (new \yii\db\Query())
                ->from('user')
                ->andWhere(['like', 'name', $arr['name']])
                ->all();
            $rows = $redis->hSet('data', 'name', $rows);
        }

        $row = json_encode(['code' => '0', 'msg' => '查询成功', 'data' => $rows]);
        $this->actionExecllist($row);

        if ($rows) {
            return $this->actionElist();
        } else {
            return $this->render('elist');
        }
    }

    public function actionExecllist($row = '')
    {
        $rows = (new \yii\db\Query())
            ->from('log')
            ->all();

        if (!empty($row)) {
            return json_encode(['code' => '0', 'msg' => '查询成功', 'data' => $row]);
            die;
        } else {
            if ($rows) {
                return json_encode(['code' => '0', 'msg' => '查询成功', 'data' => $rows]);
            } else {
                return json_encode(['code' => '1', 'msg' => '查询失败']);
            }
        }
    }
}
