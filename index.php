<?php
require_once "header.php";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }


    // 查找话题和用户信息，并获取登录用户名缓存，以获取用户昵称返回欢迎语
    $query = "SELECT * FROM posts";
    $query1 = "SELECT * FROM users where username='{$_SESSION['username']}'";

    $result = mysqli_query($connection, $query);
    $result1 = mysqli_query($connection, $query1);
    $row = mysqli_fetch_assoc($result1);

    $n = mysqli_num_rows($result);

    // 应该只有一行数据
    if ($n>0){
        $author = '';  
                //欢迎词标题，根据用户是否登录而变化。在用户登录或未登录时，可以使用不同的欢迎词标题。
                if(isset($_SESSION['loggedIn'])){
                echo <<<_END
                    <div class="jumbotron" style="background-color: rgb(23, 23, 23); padding: 20px;">
                        <table>
                            <tr>
                                <td>
                                    <h2 style="color: aliceblue;" class="display-3">Hello, {$row['nickname']}!</h2>
                                    <p style="color: aliceblue;">你可以查看此网站上发布的所有帖子</p>
                                    <p><a class="btn btn-dark btn-lg" href="create_post.php" role="button" style="margin-top: 1rem; background-color: rgb(166, 213, 255); color:#000000E6;; border-color: rgb(141, 196, 245);">创建新的话题 &raquo;</a></p>
                                </td>
                                
                            </tr>
                        </table>
                </div>
        _END;
                }
                else{
                    echo <<<_END
                    <div class="jumbotron" style="background-color: rgb(23, 23, 23); padding: 40px;">
                        <div>
                            <h4 style="color: aliceblue;" class="display-3">理工社区 欢迎你!</h4>
                            <h6 style="color: aliceblue;">你还没有登录, 请 <a style="color: rgb(84, 157, 221);" href="sign_in.php">点击登录</a> 或 <a style="color: rgb(84, 157, 221);" href="sign_up.php">点此注册</a> 来发表话题。</h6>
                            <p><a class="btn btn-dark btn-lg" href="create_post.php" role="button" style="margin-top: 1rem; background-color: rgb(166, 213, 255); color:#000000E6;; border-color: rgb(141, 196, 245);">创建新的话题 &raquo;</a></p>
                        </div>
                </div>
        _END;
                }
                
                echo '<div class="container" style="padding-top: 40px; padding-bottom: 30px"> 
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-5 col-md-3">
                                <form action="index.php" method="POST">
                                <select name="order" class="form-select form-select-sm form-select-padding-y-sm input-padding-y" aria-label="selectForm">
                                    <option selected>默认顺序</option>
                                    <option value="asc">最早话题</option>
                                    <option value="desc">最新话题</option>
                                </select>
                            </div>
                                
                            <div class="col-5 col-md-3">
                                <button type="submit" name="sort" class="btn btn-secondary btn-sm">排序</button>
                                   </form>
                            </div>
                        </div>';
                        
            
                if(isset($_POST['sort'])){
                    //话题时间升序
                    if($_POST['order'] == 'asc'){
                        $query = "SELECT * FROM posts ORDER BY created ASC";
                        $result = mysqli_query($connection, $query);
                        while($row = mysqli_fetch_assoc($result)){ 
                            if(isset($row['uid'])){
                                $name_query = "SELECT nickname FROM users WHERE uid = '{$row['uid']}'";
                                $name_result = mysqli_query($connection, $name_query);
                                $name_row = mysqli_fetch_assoc($name_result);
                                $author = $name_row['nickname'];
                            }
                            else {
                                $author = "用户已注销";
                            }
                            echo <<<_END
                            <hr>
                                <div class="row">
                                <div class="col-8"><h3> 话题: {$row['title']}</h3><p> 时间: {$row['created']}</p> <p> 作者: {$author}</p><p> 概述: {$row['content']}</p></div>
                                <div class="col-4"><img src="{$row['image']}" width="200px" class='rounded mx-auto d-block img-fluid' /></div>
                                <a class="btn btn-dark btn-sm" role="button" style="margin-top: 5px;margin-left:10px; background-color: #e1ecf4;border-radius: 3px;border: 1px solid #7aa7c7;
                                color: #39739d; width:100px" href='view-post.php?pid={$row['postid']}'>查看详情 &raquo;</a>
                                </div> 
 _END;
                        } 
                        echo '</div>';
                    }
                    //话题时间降序
                    elseif($_POST['order'] == 'desc'){
                        $query = "SELECT * FROM posts ORDER BY created DESC";
                        $result = mysqli_query($connection, $query);
                        while($row = mysqli_fetch_assoc($result)){ 
                            if(isset($row['uid'])){
                                $name_query = "SELECT nickname, stdid FROM users WHERE uid = '{$row['uid']}'";
                                $name_result = mysqli_query($connection, $name_query);
                                $name_row = mysqli_fetch_assoc($name_result);
                                $author = $name_row['nickname'];
                            }
                            else {
                                $author = "用户已注销";
                            }
                            echo <<<_END
                        <hr>
                            <div class="row">
                            <div class="col-8"><h3> 话题: {$row['title']}</h3><p> 时间: {$row['created']}</p> <p> 作者: {$author}</p><p> 概述: {$row['content']}</p></div>
                            <div class="col-4"><img src="{$row['image']}" width="200px" class='rounded mx-auto d-block img-fluid' /></div>
                            <a class="btn btn-dark btn-sm" role="button" style="margin-top: 5px;margin-left:10px; background-color: #e1ecf4;border-radius: 3px;border: 1px solid #7aa7c7;
                            color: #39739d; width:100px" href='view-post.php?pid={$row['postid']}'>查看详情 &raquo;</a>
                            </div> 
 _END;
                        } 
                        echo '</div>';
                    }
                    else{
                        while($row = mysqli_fetch_assoc($result)){ 
                            if(isset($row['uid'])){
                                $name_query = "SELECT nickname, stdid FROM users WHERE uid = '{$row['uid']}'";
                                $name_result = mysqli_query($connection, $name_query);
                                $name_row = mysqli_fetch_assoc($name_result);
                                $author = $name_row['nickname'];
                            }
                            else {
                                $author = "用户已注销";
                            }
                            echo <<<_END
                        <hr>
                            <div class="row">
                            <div class="col-8"><h3> 话题: {$row['title']}</h3><p> 时间: {$row['created']}</p> <p> 作者: {$author}</p><p> 概述: {$row['content']}</p></div>
                            <div class="col-4"><img src="{$row['image']}" width="200px" class='rounded mx-auto d-block img-fluid' /></div>
                            <a class="btn btn-dark btn-sm" role="button" style="margin-top: 5px;margin-left:10px; background-color: #e1ecf4;border-radius: 3px;border: 1px solid #7aa7c7;
                            color: #39739d; width:100px" href='view-post.php?pid={$row['postid']}'>查看详情 &raquo;</a>
                            </div>
        _END;
                        } 
                        echo '</div>';
                    }
            }
            else{
                while($row = mysqli_fetch_assoc($result)){ 
                    if(isset($row['uid'])){
                        $name_query = "SELECT nickname, stdid FROM users WHERE uid = '{$row['uid']}'";
                        $name_result = mysqli_query($connection, $name_query);
                        $name_row = mysqli_fetch_assoc($name_result);
                        $author = $name_row['nickname'];
                    }
                    else {
                        $author = "用户已注销";
                    }
                    echo <<<_END
                    <hr>
                            <div class="row">
                            <div class="col-8"><h3> 话题: {$row['title']}</h3><p> 时间: {$row['created']}</p> <p> 作者: {$author}</p><p> 概述: {$row['content']}</p></div>
                            <div class="col-4"><img src="{$row['image']}" width="200px" class='rounded mx-auto d-block img-fluid' /></div>
                            <a class="btn btn-dark btn-sm" role="button" style="margin-top: 5px;margin-left:10px; background-color: #e1ecf4;border-radius: 3px;border: 1px solid #7aa7c7;
                            color: #39739d; width:100px" href='view-post.php?pid={$row['postid']}'>查看详情 &raquo;</a>
                            </div>
_END;
                } 
                echo '</div>';
            }
        }
    // if anything else happens indicate a problem
    else {
        echo "<div class='text-center fw-bold p-4'> 没有找到相关记录.<br> </div>";
    }

require_once "footer.php";
?>