
<?php
// 段孝辰
include('..\..\conn.php');

session_start();
//注销登录
error_reporting(0);
if($_GET['action'] == "logout"){
    unset($_SESSION['userid']);
    unset($_SESSION['username']);
    echo "<script>alert('注销成功!');location.href='../../../index.html';</script>";
    exit;
}

//登录

$username = htmlspecialchars($_POST['username']);
$password = MD5($_POST['password']);


//检测用户名及密码是否正确
$sql ="select translator_ID from translator where translator_Name='$username' and translator_Password='$password' limit 1";
$check_query = mysqli_query($conn,$sql, MYSQLI_STORE_RESULT );
if($result = mysqli_fetch_array($check_query, MYSQLI_ASSOC)){
    //登录成功
    $_SESSION['username'] = $username;
    $_SESSION['userid'] = $result['uid'];
    echo '<script type="text/javascript">alert("登陆成功");window.location.href="../../../index.html";</script>';
	
    exit;
} else {
    exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
}
?>