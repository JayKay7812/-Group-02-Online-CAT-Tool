<?php
include("../../conn.php");
$action = $_GET['action'];
$userid=0;
if($action=="newtm")
{
    $tmname=$_POST["tmName"];
    $srclan=$_POST["sourceLanguage"];
    $tarlan=$_POST["targetLanguage"];
    $newtm_sql="INSERT INTO translationmemorysheet (tmsheet_Name, sourceLanguage, targetLanguage, tmsheet_Status, owner_ID) VALUES ('$tmname','$srclan','$tarlan','个人',$userid)";
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
    $tmid=$_POST["transmemory_ID"];
    echo $tmid;
    $src=$_POST["sourceText"];
    echo $src;
    $tar=$_POST["targertText"];
    echo $tar;
    $update_sql = "UPDATE `translationmemorybase` SET sourceText='$src', targertText='$tar' WHERE tm_ID='$tmid'";
    if(mysqli_query($conn, $update_sql)){
        
        echo "更新成功";
    }
    else {
        echo "error:".mysqli_error($conn);
    }
}

?>