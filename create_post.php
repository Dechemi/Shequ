<?php
require_once "header.php";


$show_signIn_form = false;
$wrong_detail_message = false;
$msg="";
$errors= "";

$title_err="";
$content_err="";

if(isset($_POST['title'])){
    // 获取用户提交
   $title = $_POST['title'];
   $content = $_POST['content'];
   $words = $_POST['words'];
   $image = $_FILES['image']['name']; // 获取上传的文件名
 
     $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
 
   if(!$connection){
     die("Connection failed: " . $mysqli_connect_error);
   }
 
   $title = sanitise($title, $connection);
   $content = sanitise($content, $connection);
   $words = sanitise($words, $connection);
   
   $title_errors = validateString($title, 3, 64);
   $content_errors = validateString($content, 5, 1328);
   $words_errors = validateString($words, 30, 6628);
 
   $errors = $title_errors . $content_errors . $words_errors;
  //  echo $errors;
   if($errors == ""){

     $date = date('Y-m-d H:i:s');
 
     if(isset($_SESSION['loggedIn'])){
         $query = "INSERT INTO posts(uid, title, created, content, image, words) VALUES('{$_SESSION['uid']}','$title', '$date', '$content','img/$image','$words')";
     }
     else {
         $query = "INSERT INTO posts(title, created, content, image, words) VALUES('$title', '$date', '$content','img/$image','$words')";
     }

     $result =  mysqli_query($connection, $query);

     if($result){
      // 保存上传的文件到 img 文件夹下
      move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $image);
 
       echo <<<_END
       <div class='text-center fw-bold p-4'> 已发布一个新的话题!<br> </div>
       <div class="text-center"> <a href="user_posts.php" class="text-primary">点击管理 </a>你的话题 </div>
     _END;
     } else {
        //  找不到匹配的凭据，因此重新显示登录表单，并显示失败消息：
         $show_signIn_form = true;
         // 显示一个登录失败的消息
         $wrong_detail_message = true;
     }
      // 关闭连接
      mysqli_close($connection);
   }
   else {
     $show_signIn_form = true;
     $wrong_detail_message = true;
   }
 }
 else {
     $show_signIn_form = true;
 }

if($show_signIn_form) {
echo <<<_END
  <!-- Log in form container  -->
<div class="container-fluid body">
  <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5 logo">
            <h1>交流 · 触及 · 心灵 <br>&<br> 分享你的<b style=" color: #9E7757;">生活</b></h1>
        </div>

        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl">
        <form method="POST" action="create_post.php" enctype="multipart/form-data">

                 <!-- Instruction -->
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-auto instruction">创建一个新的话题!</p>
                </div>
_END;
              if($wrong_detail_message){
              echo <<<_END
                <!-- Instruction -->
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-auto text-danger">字符太少,再多记录一点吧!</p>
                </div>
_END; 
              }
                echo <<<_END
                <!-- Title input -->
                <div class="form-outline mb-4">
                  <label class="form-label" id="title" for="title">话题</label>
                  <input type="text" name="title" class="form-control form-control-lg" required/>
                </div>

                <!-- Content input -->
                <div class="form-outline mb-1">
                  <label class="form-label" id="content" for="content">概述</label>
                  <textarea id="content"  name="content" rows="2" cols="50" name="content" class="form-control form-control-lg" required></textarea>
                  </div>

                <div class="form-outline mb-1">
                  <label class="form-label" id="words" for="words">正文</label>
                  <textarea id="words"  name="words" rows="4" cols="50" name="words" class="form-control form-control-lg" required></textarea>
                  </div>
                
                  <br>
                  <div class="form-outline mb-1">
                  <label class="form-label" id="image" for="image">附件</label> <br>
                  <input type="file" name="image"/>
                    </textarea>
                    <button type="submit" class="btn btn-dark btn-lg" onclick="window.location.href='index.php';"
                    style="padding-left: 2.5rem; padding-right: 2.5rem; margin-bottom: 20px; background-color: rgb(166, 213, 255); color:#000000E6;; border-color: #DECFAC;">发布</button>
                  </div>

                <!-- Post button -->
                <div class="text-center text-lg-start mt-4 pt-2">
                  
_END;     
                  if(!isset($_SESSION['loggedIn'])){
                    echo <<<_END
                    <p class="small fw-bold mt-2 pt-1 mb-0">想要编辑你之前的记录吗？ <br> 点击这里 <a href="sign_up.php"
                        class="text-primary">注册</a></p>
_END;
                  }
                    echo <<<_END
                </div>
              </form>
          </div>
    </div>
</div>
_END;
}

require_once "footer.php";
?>