
<?php
// 段孝辰
$job = $_POST['job'];
$username = $_POST['username'];
$password = $_POST['password'];

//注册信息判断
if(!preg_match('/^[\w\x80-\xff]{3,15}$/', $username)){
    exit('错误：用户名不符合规定。<a href="javascript:history.back(-1);">返回</a>');
}
if(strlen($password) < 6){
    exit('错误：密码长度必须大于六位。<a href="javascript:history.back(-1);">返回</a>');
}

//包含数据库连接文件
include('..\..\conn.php');
//检测用户名是否已经存在
if($job='项目经理'){
	$sql ="select pm_ID from projectmanager where pm_Name='$username' limit 1";
	$check_query = mysqli_query($conn,$sql, MYSQLI_STORE_RESULT );
	if(mysqli_fetch_array($check_query, MYSQLI_ASSOC)){
	    echo "<script>alert('用户已存在!');location.href='../../../webpage/register.html';</script>";
	    exit;
	}
	//写入数据
	$password = MD5($password);
	$regdate = time();
	$sql = "INSERT INTO projectmanager(pm_Name,pm_Password)VALUES('$username','$password')";
}
else if($job='普通译员'){
	$sql ="select translator_ID from translator where translator_Name='$username' limit 1";
	$check_query = mysqli_query($conn,$sql, MYSQLI_STORE_RESULT );
	if(mysqli_fetch_array($check_query, MYSQLI_ASSOC)){
	    echo "<script>alert('用户已存在!');location.href='../../../webpage/register.html';</script>";
	    exit;
	}
	//写入数据
	$password = MD5($password);
	$regdate = time();
	$sql = "INSERT INTO translator(translator_Name,translator_Password)VALUES('$username','$password')";
}




if(mysqli_query($conn,$sql)){
    echo "<script>alert('注册成功!');location.href='../../../webpage/login.html';</script>";
    
} else {
    echo '抱歉！添加数据失败：',mysqli_error($conn),'<br />';
    echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
}
?>