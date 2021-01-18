// 秦浩洋
<?php
  include ('../../conn.php');
  print_r($_FILES);
  if ($_FILES["file"]["error"] > 0)
    {
      echo '<script type="text/javaScript">alert("导入tm失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
    }
  else
    {
      if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
        echo '<script>alert("tm文件已存在！");window.location.href="/Group-02-Online-CAT-Tool/webpage/project0.html";</script>';
      }
      else
      {
        session_start();
        $userid=$_SESSION['userid'];
      	$file = $_FILES["file"];
      	$filename=$file["tmp_name"];
      	$pinfo=pathinfo($file["name"]);
      	$ftype=$pinfo['extension'];
        $setname=$_POST["tmsheetName"];
      	$savename = $setname.".xlsx";
      	$destination = "upload/".$savename;
      	move_uploaded_file($filename,$destination);
        $sourceLanguage=$_POST['sourceLanguage'];
        $targetLanguage=$_POST['targetLanguage'];
        $sql="INSERT INTO translationmemorysheet (tmsheet_Name, sourceLanguage, targetLanguage, owner_ID) VALUES ('$savename', '$sourceLanguage', '$targetLanguage','$userid')";

        if (mysqli_query($conn, $sql)) {
          echo "新记录插入成功";
          $sql1="SELECT tmsheet_ID FROM translationmemorysheet WHERE tmsheet_Name='$savename'";
          $tmsheet_ID=mysqli_fetch_array(mysqli_query($conn, $sql1))[0];
        } else {
          echo '<script type="text/javaScript">alert("导入文件失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        //echo '<script>alert("导入文件成功！");window.location.href="javascript:history.back(-1);";</script>';
      }
    }
    include ('tmparser.php');
?>
