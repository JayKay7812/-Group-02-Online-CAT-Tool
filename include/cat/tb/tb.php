<?php
header("content-type:text/html; charset=utf-8");//如果点击新建TB后报错：Feild tbsheet_ID have no default value，需去数据库将tbsheet_ID字段设为自增 李善灡
include("../../conn.php");
$action = $_GET['action'];
session_start();
$userid=$_SESSION['userid'];
if($action=="newtb")
{
    $tbname=$_POST["tbName"];
    $srclan=$_POST["sourceLanguage"];
    $tarlan=$_POST["targetLanguage"];
    $newtb_sql="INSERT INTO termsheet (tbsheet_Name, sourceLanguage, targetLanguage, tbsheet_Status, owner_ID) VALUES ('$tbname','$srclan','$tarlan','个人','$userid')";
    $check_sql="SELECT tbsheet_Name from termsheet where tbsheet_Name = '$tbname'";
    
   if(mysqli_fetch_assoc(mysqli_query($conn, $check_sql))==null)
    {
        if(mysqli_query($conn, $newtb_sql)){

            echo '<script>alert("新建术语库成功！");window.location.href="../../../webpage/termbase.html";</script>';
        }
        else {
            echo "error:".mysqli_error($conn);
        }
    }
    else
    {
        echo '<script>alert("术语库名已存在！");window.location.href="../../../webpage/termbase.html";</script>';
    }
}
else if($action=="edit")
{
    $sheet_ID=$_GET["sheetid"];
    $tbid=$_POST["term_ID"];//记得把链接过来的页面里的tb_ID换成term_ID
    echo $tbid;
    $src=$_POST["zh_CN"];
    $src=htmlspecialchars($src,ENT_QUOTES);
    echo $src;
    $tar=$_POST["en_US"];
    $tar=htmlspecialchars($tar,ENT_QUOTES);
    echo $tar;
    $def=$_POST["term_Definition"];
    $def=htmlspecialchars($def,ENT_QUOTES);

    if($tbid==NULL)
    {
        $addrow_sql="INSERT INTO termbase (tbsheet_ID,zh_CN,en_US,`term_Definition`) VALUES ($sheet_ID,'$src','$tar','$def')";
        if(!mysqli_query($conn, $addrow_sql)){
        
            echo "添加术语出错:".mysqli_error($conn);
        }
        else {
            echo "添加术语成功";
        }
    }
    else{
        $update_sql = "UPDATE `termbase` SET zh_CN='$src', en_US='$tar',term_Definition='$def' WHERE (term_ID='$tbid' and tbsheet_ID=$sheet_ID)";
        if(!mysqli_query($conn, $update_sql)){
            
            echo "error:".mysqli_error($conn);
        }
        else {
            echo "更新术语成功";
        }
    }
    
}

else if($action=="del")
{
    $id=$_POST["id"];
    $name=$_POST["name"];
    $del_sql="INSERT into deletedfile (deleted_ID, del_name, `type`) values ($id,'$name','术语')";
    if(!mysqli_query($conn, $del_sql)){
            
        echo "error:".mysqli_error($conn);
    }
    else {
        echo "删除术语成功";
    }
}
else if($action=="del2")
{
    $id=$_POST["id"];
    $name=$_POST["name"];
    $del_sql="DELETE from termbase where term_ID=$id";
    if(!mysqli_query($conn, $del_sql)){
            
        echo "error:".mysqli_error($conn);
    }
    else {
        echo "删除成功";
    }
}
?>

