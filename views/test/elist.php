<?php

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/layui.css" media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>

<body>
    <?= Html::beginForm(['test/esearch'], 'post', ['class' => 'layui-form']) ?>
    <input type="text" name="name" style="width: 200px;" class="layui-input">
    <button class="layui-btn " lay-filter="demo1">搜索</button>
    <?= Html::endForm() ?>

    <table class="layui-hide" id="test"></table>


    <script src="layui.js" charset="utf-8"></script>
    <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->

    <script>
        layui.use('table', function() {
            var table = layui.table;

            table.render({
                elem: '#test',
                url: 'http://127.0.0.1/rk/ykB/basic/web/index.php?r=test/execllist',
                cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
                    ,
                cols: [
                    [{
                        field: 'id',
                        width: 200,
                        title: 'ID',
                        sort: true
                    }, {
                        field: 'name',
                        width: 200,
                        title: '用户名'
                    }, {
                        field: 'ip',
                        width: 200,
                        title: 'ip'
                    }, {
                        field: 'desc',
                        width: 200,
                        title: '操作'
                    }, {
                        field: 'time',
                        title: '操作时间',
                        sort: true
                    }]
                ]
            });
        });
    </script>

</body>

</html>