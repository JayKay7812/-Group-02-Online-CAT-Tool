<?php
  include ('../conn.php');
  mysqli_select_db($conn,'cat');
  mysqli_query($conn,"set names utf8");
  $sql="SELECT project_ID,project_Name,source_Language,target_language,project_Status,due_Date FROM project";
  $return = array();
  $huoqu = mysqli_query($conn,$sql);
  while($row= mysqli_fetch_array($huoqu,MYSQLI_ASSOC)){
      $return['rows'][] = $row;
  }
  echo(json_encode($return));
?>
