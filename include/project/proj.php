<?php
include("../conn.php");
session_start();
$userid=$_SESSION['userid'];
$id=$_POST["id"];
$name=$_POST["name"];
$action=$_GET["action"];

if($action=="project")
{
    $del_sql="INSERT into deletedfile (deleted_ID, del_name, `type`) values ($id,'$name','项目')";
}
else if($action=="file")
{
    $del_sql="INSERT into deletedfile (deleted_ID, del_name, `type`) values ($id,'$name','文件')";
}

if(!mysqli_query($conn, $del_sql)){
        
    echo "error:".mysqli_error($conn);
}
else {
    echo "删除成功";
}
?>