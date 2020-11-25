// 段孝辰
<?php

include('..\include\conn.php');

session_start();
//注销登录
error_reporting(0);
if($_GET['action'] == "logout"){
    unset($_SESSION['userid']);
    unset($_SESSION['username']);
    echo 'Log out successfully!点击此处 <a href="login.php">登录</a>';
    exit;
}

//登录
if(!isset($_POST['submit'])){
    exit('非法访问!');
}
$username = htmlspecialchars($_POST['trsltrname']);
$password = MD5($_POST['password']);


//检测用户名及密码是否正确
$sql ="select translator_ID from translator where translator_Name='$username' and translator_Password='$password' limit 1";
$check_query = mysqli_query($conn,$sql, MYSQLI_STORE_RESULT );
if($result = mysqli_fetch_array($check_query, MYSQLI_ASSOC)){
    //登录成功
    $_SESSION['username'] = $username;
    $_SESSION['userid'] = $result['uid'];
    echo '<script type="text/javascript">alert("登陆成功");window.location.href="login.php";</script>';
	
    exit;
} else {
    exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
}
?>