<?php
$dbhost = 'localhost:3306';  //mysql服务器主机地址
$dbuser = 'root';      //mysql用户名
$dbpass = '';//mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysqli_error());
}

mysqli_select_db( $conn,'cat' );
mysqli_query($conn,"set names utf8");
?>
