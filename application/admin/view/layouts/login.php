<?php use app\common\services\Urlservice;
\backend\assets\LoginAppasset::register($this);

$this->beginPage();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title>登录界面</title>
    <?php $this->head();?>
<!--    <link href="css/default.css" rel="stylesheet" type="text/css" />-->
    <!--必要样式-->
<!--    <link href="css/styles.css" rel="stylesheet" type="text/css" />-->
<!--    <link href="css/demo.css" rel="stylesheet" type="text/css" />-->
<!--    <link href="css/loaders.css" rel="stylesheet" type="text/css" />-->
</head>
<body>
<?php $this->beginBody();?>

<?php echo $content;?>
<div class='authent'>
    <div class="loader" style="height: 44px;width: 44px;margin-left: 28px;">
        <div class="loader-inner ball-clip-rotate-multiple">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <p>认证中...</p>
</div>
<div class="OverWindows"></div>

<?php $this->js;?>
<!--<script type="text/javascript" src="js/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="js/jquery-ui.min.js"></script>-->
<!--<script type="text/javascript" src='js/stopExecutionOnTimeout.js?t=1'></script>-->
<!--<script type="text/javascript" src="layui/layui.js"></script>-->
<!--<script type="text/javascript" src="js/Particleground.js"></script>-->
<!--<script type="text/javascript" src="Js/Treatment.js"></script>-->
<!--<script type="text/javascript" src="js/jquery.mockjax.js"></script>-->

<?php $this->endBody();?>
</body>
<script type="text/javascript">
    var canGetCookie = 0;//是否支持存储Cookie 0 不支持 1 支持
//    var ajaxmockjax = 0;//是否启用虚拟Ajax的请求响 0 不启用  1 启用
    //默认账号密码
    var codee = '';
    var CodeVal = 0;
    Code();
    function Code() {
        codee = createCode("");
        showCheck(codee);
    }
    function showCheck(a) {
        CodeVal = a;
        var c = document.getElementById("myCanvas");
        var ctx = c.getContext("2d");
        ctx.clearRect(0, 0, 1000, 1000);
        ctx.font = "80px 'Hiragino Sans GB'";
        ctx.fillStyle = "#E8DFE8";
        ctx.fillText(a, 0, 100);
    }
    $(document).keypress(function (e) {
        // 回车键事件
        if (e.which == 13) {
            $('input[type="button"]').click();
        }
    });
    //粒子背景特效
    $('body').particleground({
        dotColor: '#E8DFE8',
        lineColor: '#133b88'
    });
    $('input[name="pwd"]').focus(function () {
        $(this).attr('type', 'password');
    });
    $('input[type="text"]').focus(function () {
        $(this).prev().animate({ 'opacity': '1' }, 200);
    });
    $('input[type="text"],input[type="password"]').blur(function () {
        $(this).prev().animate({ 'opacity': '.5' }, 200);
    });
    $('input[name="login"],input[name="pwd"]').keyup(function () {
        var Len = $(this).val().length;
        if (!$(this).val() == '' && Len >= 5) {
            $(this).next().animate({
                'opacity': '1',
                'right': '30'
            }, 200);
        } else {
            $(this).next().animate({
                'opacity': '0',
                'right': '20'
            }, 200);
        }
    });
//    var open = 0;
    layui.use('layer', function () {
//        //非空验证
        $('input[type="button"]').click(function () {
            var login = $('input[name="login"]').val();
            var pwd = $('input[name="pwd"]').val();
            var code = $('input[name="code"]').val();

//           alert(codee);return;
            if (login == '') {
                ErroAlert('请输入您的账号');
            } else if (pwd == '') {
                ErroAlert('请输入密码');
            } else if (code == '' || code.length != 4) {
                ErroAlert('输入验证码');
            } else {
                //认证中..
                fullscreen();
                $('.login').addClass('test'); //倾斜特效
                setTimeout(function () {
                    $('.login').addClass('testtwo'); //平移特效
                }, 300);
                setTimeout(function () {
                    $('.authent').show().animate({right: -320}, {
                        easing: 'easeOutQuint',
                        duration: 600,
                        queue: false
                    });
                    $('.authent').animate({opacity: 1}, {
                        duration: 200,
                        queue: false
                    }).addClass('visible');
                }, 500);
                //ajax验证用户名密码验证码是否正确
                $.ajax({
                    type:"post",
                    url:"<?php echo Urlservice::YY('login/index')?>",
                    data:{"login":login,"pwd":pwd,"codee":codee,"code":code},
                    dataType:"json",
                    success:function(msg){
                           //登录时特效
                            setTimeout(function () {
                                $('.authent').show().animate({right: 90}, {
                                    easing: 'easeOutQuint',
                                    duration: 600,
                                    queue: false
                                });
                                $('.authent').animate({opacity: 0}, {
                                    duration: 200,
                                    queue: false
                                }).addClass('visible');
                                $('.login').removeClass('testtwo'); //平移特效
                            }, 2000);
                            setTimeout(function () {
                                $('.authent').hide();
                                $('.login').removeClass('test');
                                if(msg.status == 'ok'){
                                    //登录成功'
                                    $('.login div').fadeOut(100);
                                    $('.success').fadeIn(1000);
                                    //登录成功创建form表单提交用户信息
                                    var data = msg.userInfo;
                                    var form = $("<form></form>");
                                    form.attr("action","<?php echo Urlservice::YY('user/index')?>");
                                    form.attr("method","post");
                                    for(var v in data){
                                        var input_text = $("<input type='hidden' name='"+v+"' value='"+data[v]+"'/>");
                                        form.append(input_text);
                                    }
                                    //跳转操作
                                    form.appendTo(document.body).submit();
                                }else{
                                   ErroAlert(msg.message);
                                }
                            }, 2400);
                    }
                });
            }
        })
    })
    var fullscreen = function () {
        elem = document.body;
        if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.requestFullScreen) {
            elem.requestFullscreen();
        } else {
            //浏览器不支持全屏API或已被禁用
        }
    }
    function subForm(data){


    }
</script>
</html>
<?php $this->endPage();?>
