<?php

require_once "header.php";

if (!isset($_SESSION['loggedIn']))
{
    // 用户未登录，请显示一条消息，提示他们必须登录：
    echo "你必须要先登录才能浏览这个页面!<br>";
}
else
{
    // 用户点击注销，销毁会话数据：
    // 首先清除会话全局数组：
    $_SESSION = array();
    // 清除保存会话ID的Cookie：
    setcookie(session_name(), "", time() - 2592000, '/');
    // 关闭session
    session_destroy();


    header("Location: index.php");
}

require_once "footer.php";

?>