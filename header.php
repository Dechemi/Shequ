<?php

    require_once "credentials.php";

    require_once "helper.php";

    //设置时钟时区
    date_default_timezone_set('Asia/Chongqing');

    session_start();
    
    echo <<< _END
        <!DOCTYPE html>
        <head> 
        <meta charset="utf-8">
        <title>理工社区</title>

        <link id="stylesheet" rel="stylesheet" href="css/custom.css"/> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <script src="js/custom.js" type="text/javascript"></script>
        </head>
        <body onload=display_ct();>
_END;
 
    if(isset($_SESSION['loggedIn'])){

        if(strtolower($_SESSION['username']) == "admin"){
            echo <<<_END
            <nav class="navbar navbar-expand-lg navbar-light" style="background-color: black; padding: 20px;">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <img src="images/logo2.jpg" class="img-fluid  list-inline" width="80px" height="80px">
                    <div class="collapse navbar-collapse" id="navbarNav" style="padding-top:20px;margin-left: 40px;">
                    
                        <div class="btn-group adminDropdown">
                            <button style="color: aliceblue;" type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                管理
                            </button>
                            <ul class="dropdown-menu text-center adminDropdown" >
                                <li><a class="dropdown-item" href="manage_posts.php">管理话题</a></li>
                                <li><a class="dropdown-item" href="manage_users.php">管理用户</a></li>
                            </ul>
                        </div>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a style="color: aliceblue;" class="nav-link" href="index.php">主页</a></li>
                            <li class="nav-item"><a style="color: aliceblue;" class="nav-link" href="create_post.php">创建话题</a></li>
                            <li class="nav-item"><a style="color: aliceblue;" class="nav-link" href="user_posts.php">编辑话题</a></li>
                            <li class="nav-item">
                            </li>
                            <li class="nav-item"><a style="color: aliceblue;" class="nav-link" href="sign_out.php">退出登录</a></li>
            _END; 
            require_once "nav_end.php";
        }

        else {
            
            require_once "nav_start.php";
            echo <<<_END
                <li class="nav-item"><a style="color: aliceblue;" class="nav-link" href="user_posts.php">编辑话题</a></li>                
                <li class="nav-item"><a style="color: aliceblue;" class="nav-link" href="sign_out.php">退出登录</a></li>
            _END;
            require_once "nav_end.php";
        }
    }
    //未登录
    else{
        require_once "nav_start.php";
        echo <<<_END
            <li class="nav-item"><a style="color: aliceblue;" class="nav-link" href="sign_in.php">登录</a></li>
            <li class="nav-item"><a style="color: aliceblue;" class="nav-link" href="sign_up.php">注册</a></li>
        _END;
        require_once "nav_end.php";
    }
?>