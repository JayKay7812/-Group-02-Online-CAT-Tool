<?php
include("../../conn.php");
$action = $_GET['action'];
session_start();
$userid=$_SESSION['userid'];
if($action=="newtm")
{
    $tmname=$_POST["tmName"];
    $srclan=$_POST["sourceLanguage"];
    $tarlan=$_POST["targetLanguage"];
    $newtm_sql="INSERT INTO translationmemorysheet (tmsheet_Name, sourceLanguage, targetLanguage, tmsheet_Status, owner_ID) VALUES ('$tmname','$srclan','$tarlan','个人','$userid')";
    $check_sql="SELECT tmsheet_Name from translationmemorysheet where tmsheet_Name = '$tmname'";
    
   if(mysqli_fetch_assoc(mysqli_query($conn, $check_sql))==null)
    {
        if(mysqli_query($conn, $newtm_sql)){

            echo '<script>alert("新建项目成功！");window.location.href="../../../webpage/translation-memory.html";</script>';
        }
        else {
            echo "error:".mysqli_error($conn);
        }
    }
    else
    {
        echo '<script>alert("项目名已存在！");window.location.href="../../../webpage/translation-memory.html";</script>';
    }
}
else if($action=="edit")
{
    $sheet_ID=$_GET["sheetid"];
    $tmid=$_POST["tm_ID"];
    echo $tmid;
    $src=$_POST["sourceText"];
    $src=htmlspecialchars($src,ENT_QUOTES);
    echo $src;
    $tar=$_POST["targertText"];
    $tar=htmlspecialchars($tar,ENT_QUOTES);
    echo $tar;

    if($tmid==NULL)
    {
        $addrow_sql="INSERT INTO translationmemorybase (tmsheet_ID,sourceText,targertText) VALUES ($sheet_ID,'$src','$tar')";
        if(!mysqli_query($conn, $addrow_sql)){
        
            echo "添加error:".mysqli_error($conn);
        }
        else {
            echo "添加成功";
        }
    }
    else{
        $update_sql = "UPDATE `translationmemorybase` SET sourceText='$src', targertText='$tar' WHERE (tm_ID='$tmid' and tmsheet_ID=$sheet_ID)";
        if(!mysqli_query($conn, $update_sql)){
            
            echo "error:".mysqli_error($conn);
        }
        else {
            echo "更新成功";
        }
    }
    
}

else if($action=="del")
{
    $id=$_POST["id"];
    $name=$_POST["name"];
    $del_sql="INSERT into deletedfile (deleted_ID, del_name, `type`) values ($id,'$name','TM')";
    if(!mysqli_query($conn, $del_sql)){
            
        echo "error:".mysqli_error($conn);
    }
    else {
        echo "删除成功";
    }
}
else if($action=="del2")
{
    $id=$_POST["id"];
    $name=$_POST["name"];
    $del_sql="DELETE from translationmemorybase where tm_ID=$id";
    if(!mysqli_query($conn, $del_sql)){
            
        echo "error:".mysqli_error($conn);
    }
    else {
        echo "删除成功";
    }
}

?>