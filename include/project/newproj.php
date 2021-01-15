<?php
  include ('../conn.php');
  $project_Name=$_POST["projName"];
  $sourceLanguage=$_POST["sourceLanguage"];
  $targetLanguage=$_POST["targetLanguage"];
  $dueDate=$_POST["dueDate"];
  $tmSetting=$_POST["tmSetting"];
  $tbSetting=$_POST["tbSetting"];
  echo $tbSetting;
  echo "<br/>";
  echo $tmSetting;
  echo "<br/>";
  $accountID=12;
  $accountType="user";

#,`source_Language`,`target_Language`,`due_Date`   ,'$sourceLanguage','$targetLanguage','$dueDate'
  #if($accountType=="user")
  #{
    $insert_sql = "INSERT INTO `project` (`PM_ID`,`project_Name`,`project_Status`,`project_Property`,`source_Language`,`target_Language`,`due_Date`) VALUES ('{$_SESSION["username"]}','$project_Name','opened','personal','$sourceLanguage','$targetLanguage','$dueDate')";
  #}
  #else if($accountType=="PM")
  #{
  #  $insert_sql = "INSERT INTO `project` (`owner_ID`,`project_ID`, `project_Name`,`project_Status`,`project_Property`,`source_Language`,`target_Language`,`due_Date`) VALUES ('$accountID','$project_ID', '$project_Name','opened','teamed','$sourceLanguage','$targetLanguage','$dueDate')";
  #}

  $get_pro_id="select project_ID from project where project_Name='$project_Name'";
  $result=mysqli_fetch_assoc(mysqli_query($conn, $get_pro_id));
  $project_ID=$result["project_ID"];
  echo $project_ID;

  /*$get_tmb_id="select tbsheet_ID from termsheet where tbsheet_Name='$tbSetting'";
  $result=mysqli_fetch_assoc(mysqli_query($conn, $get_tmb_id));
  $tmb_ID=$result["tbsheet_ID"];
  echo $tmb_ID;
  $get_tm_id="select tmsheet_ID from translationmemorysheet where tmsheet_Name='$tmSetting'";
  $result=mysqli_fetch_assoc(mysqli_query($conn, $get_tm_id));
  $tm_ID=$result["tmsheet_ID"];
  echo $tm_ID;*/
  $newrelation_term="INSERT INTO relationsheet1 (project_ID,tmb_ID) VALUES ($project_ID,$tbSetting);";
  $add_rela1=mysqli_query($conn, $newrelation_term);
  if(!$add_rela1)
	{
    echo "error:".mysqli_error($conn);
	}
	else
	{
    echo "1成功！";
  }
  $newrelation_tb="INSERT INTO relationsheet2 (project_ID,tb_ID) VALUES ($project_ID,$tmSetting);";
  $add_rela2=mysqli_query($conn, $newrelation_tb);
  if(!$add_rela2)
	{
    echo "error:".mysqli_error($conn);
	}
	else
	{
    echo "2成功！";
  }


  $status = mysqli_query($conn,$insert_sql);
	if(!$status)
	{
    echo '<script type="text/javaScript">alert("新建项目失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
	}
	else
	{
    echo '<script>alert("新建项目成功！");</script>';
  }
 ?>
