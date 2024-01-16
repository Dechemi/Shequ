<?php
require_once "header.php";


$show_signIn_form = false;
$wrong_detail_message = false;
$errors= "";

$title_err="";
$content_err="";

if (isset($_SESSION['loggedIn']))
{
    if(isset($_POST['title'])){
        //获取表单信息
       $title = $_POST['title'];
       $content = $_POST['content'];
       $words = $_POST['words'];
       $img = $_POST['image'];
       $postid = $_POST['postid'];
  
      $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
     
       if(!$connection){
         die("Connection failed: " . $mysqli_connect_error);
       }
     
       //输入验证
       $title = sanitise($title, $connection);
       $content = sanitise($content, $connection);
       
       $title_errors = validateString($title, 3, 164);
       $content_errors = validateString($content, 0, 800);
     
       $errors = $title_errors . $content_errors;
       echo $errors;
       
       if($errors == ""){
    
         $date = date('Y-m-d H:i:s');

         $query = "UPDATE posts SET title = '{$title}', content='{$content}', created = '{$date}', words = '{$words}' WHERE postid = '{$postid}'";
    
         $result =  mysqli_query($connection, $query);
        
         if($result){
     
           // 成功
           echo "<div class='text-center fw-bold p-4 display-6 p-3 mb-2 bg-secondary text-white'>修改成功 <br></div> <div class='text-center'> <a href='user_posts.php'>点击查看</a> 你的其它话题</div>";
         } else {

            echo <<<_END
             <!-- Instruction -->
             <div class="divider d-flex align-items-center my-4">
               <p class="text-center fw-bold mx-auto text-danger">字符太少,请再试一次</p>
             </div>
_END;
         }

          mysqli_close($connection);
       }
       else {
        echo "errors";
       }
     }
     else {
         echo "未检测到请求。";
     }
}
else{
    echo "未登录";
}

echo '</body>
<footer class="page-footer font-small footer"  style="background-color:black; color:aliceblue; width: 100%;  position: absolute; bottom: 0;">
  <div class="footer-copyright text-center py-3">© 2023 版权所有: wc sjx
  </div>
<script src="js/custom.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</footer>';
?>