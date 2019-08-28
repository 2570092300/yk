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
    <a href="?r=test/login">密码登录</a>
    <?= Html::beginForm(['test/login_phone_do'], 'post', ['class' => 'layui-form']) ?>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">验证手机</label>
            <div class="layui-input-block">
                <input type="tel" name="phone" lay-verify="required|phone" placeholder="请输入手机号" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">登录</button>
        </div>
    </div>
    <?= Html::endForm() ?>



    <script src="layui.js" charset="utf-8"></script>
    <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
    <script>
        layui.use(['form', 'layedit', 'laydate'], function() {
            var form = layui.form,
                layer = layui.layer,
                layedit = layui.layedit,
                laydate = layui.laydate;

            //自定义验证规则
            form.verify({
                name: function(value) {
                    if (value.length < 3) {
                        return '标题至少得3个字符啊';
                    }
                },
                pass: [
                    /^[\S]{4,12}$/, '密码必须4到12位，且不能出现空格'
                ],
                content: function(value) {
                    layedit.sync(editIndex);
                }
            });

            // //监听提交
            // form.on('submit(demo1)', function(data) {
            //     layer.alert(JSON.stringify(data.field), {
            //         title: '最终的提交信息'
            //     })
            //     return false;
            // });

        });
    </script>

</body>

</html>