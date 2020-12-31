<?php
	include('conn.php');
	$userid=1;
	$type = $_GET['type'];

	if($type==1){
		$sql="SELECT project_ID,project_Name,source_Language,target_Language,project_Status,due_Date FROM project where PM_ID like '$userid'";
	}
	else if($type==2){
		$projectid = $_GET['projectid'];
		$sql="SELECT translationsheet_ID, file_Name, sourceLanguage, targetLanguage from translationsheet where project_ID=$projectid";
	}

	$result=mysqli_query($conn,$sql);

	$arr = array();
	// 输出每行数据
	while($row = mysqli_fetch_assoc($result)) {

				$return['rows'][] = $row;
			#$count=count($row);//不能在循环语句中，由于每次删除row数组长度都减小
	    #for($i=0;$i<$count;$i++){
	    #    unset($row[$i]);//删除冗余数据
	    #}
	    #array_push($arr,$row);

	}
	echo json_encode($return);//json编码
?>
