<?php
  include ('../conn.php');
  $project_Name=$_POST["projName"];
  $sourceLanguage=$_POST["sourceLanguage"];
  $targetLanguage=$_POST["targetLanguage"];
  $dueDate=$_POST["dueDate"];
  $accountID=12;
  $accountType="user";
  $project_ID=12;
#,`source_Language`,`target_Language`,`due_Date`   ,'$sourceLanguage','$targetLanguage','$dueDate'
  #if($accountType=="user")
  #{
    $insert_sql = "INSERT INTO `project` (`PM_ID`,`project_Name`,`project_Status`,`project_Property`,`source_Language`,`target_Language`,`due_Date`) VALUES ('{$_SESSION["username"]}','$project_Name','opened','personal','$sourceLanguage','$targetLanguage','$dueDate')";
  #}
  #else if($accountType=="PM")
  #{
  #  $insert_sql = "INSERT INTO `project` (`owner_ID`,`project_ID`, `project_Name`,`project_Status`,`project_Property`,`source_Language`,`target_Language`,`due_Date`) VALUES ('$accountID','$project_ID', '$project_Name','opened','teamed','$sourceLanguage','$targetLanguage','$dueDate')";
  #}

  $status = mysqli_query($conn,$insert_sql);
	if(!$status)
	{
    echo '<script type="text/javaScript">alert("新建项目失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
	}
	else
	{
    echo '<script>alert("新建项目成功！");window.location.href="../../webpage/project.html";</script>';
	}
 ?>
