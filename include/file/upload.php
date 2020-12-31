// 秦浩洋
<?php
  include ('../conn.php');
  print_r($_FILES);
  if ($_FILES["file"]["error"] > 0)
    {
      echo '<script type="text/javaScript">alert("导入文件失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
    }
  else
    {
      if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
        echo '<script>alert("文件已存在！");window.location.href="/Group-02-Online-CAT-Tool/webpage/project0.html";</script>';
      }
      else
      {
      	$file = $_FILES["file"];
      	$filename=$file["tmp_name"];
      	$pinfo=pathinfo($file["name"]);
      	$ftype=$pinfo['extension'];
        $setname=$_POST["fileName"];
      	$savename = $setname.".".$ftype;
      	$destination = "upload/".$savename;
      	move_uploaded_file($filename,$destination);
        $projectid = $_GET['projectid'];
        $sourceLanguage=$_POST['sourceLanguage'];
        $targetLanguage=$_POST['targetLanguage'];
        $sql="INSERT INTO translationsheet (file_Name, sourceLanguage, targetLanguage, project_ID) VALUES ('$savename', '$sourceLanguage', '$targetLanguage', '$projectid')";

        if (mysqli_query($conn, $sql)) {
          echo "新记录插入成功";
        } else {
          echo '<script type="text/javaScript">alert("导入文件失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        //echo '<script>alert("导入文件成功！");window.location.href="/Group-02-Online-CAT-Tool/webpage/project0.html";</script>';
      }
    }
    include ('../API/parser.php');
?>
