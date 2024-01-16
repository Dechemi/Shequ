<?php
require_once "header.php";

if(isset($_SESSION['loggedIn'])){
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    // 查找话题和用户信息，并获取登录用户名缓存，以获取用户昵称返回欢迎语
    $query = "SELECT * FROM posts WHERE uid='{$_SESSION['uid']}'";
    $query1 = "SELECT * FROM users WHERE username='{$_SESSION['username']}'";
// echo $query1;

    $result = mysqli_query($connection, $query);
    $result1 = mysqli_query($connection, $query1);
    $row = mysqli_fetch_assoc($result1);

    $n = mysqli_num_rows($result);

    if ($n>0){
        echo <<<_END
          <div class="jumbotron" style="background-color: rgb(23, 23, 23); padding: 40px;">
              <div>
                  <h2 style="color: aliceblue;" class="display-3">Hello, {$row['nickname']}!</h2>
                  <p style="color: aliceblue;">在这里，您可以查看、编辑和删除您的社区上的帖子</p>
                  <p><a class="btn btn-dark btn-lg" href="create_post.php" role="button" style="margin-top: 1rem; background-color: rgb(166, 213, 255); color:#000000E6;; border-color: rgb(141, 196, 245);">创建新的话题 &raquo;</a></p>
                </div>
              <img src="images/editpic.png" height="150px" width="150px" style="text-align: right; float: right;"/>
          </div>


          <div class="container" style="padding-top: 100px;">
             <div class="row" >
                
_END;

        for($i=0; $i<$n; $i++) {

        $row = mysqli_fetch_assoc($result);
            
        echo  '<div class="col-md-4" style="padding-bottom:20px;">
              <h3> 标题: '.$row['title'].'</h3>
              <p> 时间: '.$row['created'].'</p>
              <P> 话题id: '.$row['postid'].'</p>
              <p> 概述: '.$row['content'].'</p>
              <div style="float: left; padding-bottom: 10px;">

                  <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal'.$row['postid'].'">
                      修改
                  </button>

                  <!-- Modal -->
                  <div class="modal" id="editModal'.$row['postid'].'" tabindex="-1" aria-labelledby="editModalLabel'.$row['postid'].'" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel'.$row['postid'].'">修改话题</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <input type="text" value="'.$row['postid'].'" readonly/>
                              <form method="POST" action="edit_post.php">
                                <div class="mb-3">
                                  <label for="title" class="col-form-label">标题:</label>
                                  <input type="text" class="form-control" name="title" value="'.$row['title'].'" required>
                                </div>
                                <div class="mb-3">
                                  <label for="content" class="col-form-label">概述:</label>
                                  <textarea class="form-control" name="content" rows="4" cols="50" required>'.$row['content'].'</textarea>
                                </div>
                                <div class="mb-3">
                                  <label for="content" class="col-form-label">正文:</label>
                                  <textarea class="form-control" name="words" rows="5" cols="50" required>'.$row['words'].'</textarea>
                                </div>
                                <div class="mb-3">
                                  <label for="image" class="col-form-label">图片:</label>
                                  <input type="hidden" name="postid" value="'.$row['postid'].'"/>
                                  <input type="text" class="form-control" readonly name="image" value="'.$row['image'].'" required>
                                </div>
                                <div class="modal-footer">
                                 <button type="submit" class="btn btn-success">重新发布</button>
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
                  </div>


                  <!--  Modal Delete -->  <!-- 使用静态示例 -->
                  
                  <div class="modal fade" id="deleteModal'.$row['postid'].'" aria-hidden="true" aria-labelledby="deleteModalLabel'.$row['postid'].'" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deletetoggleLabel">删除话题</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                          <p> 你确定要删除这个话题吗? 话题id: "'.$row['postid'].'"<br> 已删除的话题将无法访问.</p>
                          </div>
                          <form method="POST" action="delete-posts.php">
                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                              <button type="submit" class="btn btn-danger" value="'.$row['postid'].'" name="delete">删除</button>
                          </div>
                        </form>
                      </div>
                   </div>
                 </div>
                 <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal'.$row['postid'].'">删除</button>
              </div>';
            

          
          echo '</div>';
}
        echo <<<_END
        </div>
          </div>
_END;
    }

    else {
        echo "<div class='text-center fw-bold p-4'> 没有找到记录<br> </div>";
    }
}
else {
    echo "You must be logged in to see this page";
}

require_once "footer.php";

?>