<?php
  include('conn.php');
  $userid=1;
  $type=$_GET['type'];
  if(type==1)
  {
    $sql="INSERT INTO filefortranslation (file_Name, file_Format, due_Date, project_ID)
    VALUES ('', 'Doe', 'john@example.com')";
  }
 ?>
