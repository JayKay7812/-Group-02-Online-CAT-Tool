?php
	include('conn.php');
	$userid=1;
	$type = $_GET['type'];
	if($type==1){
		$sql="select project_ID,project_Name,project_Language,project_progress,project_ddl,project_Status from project where PM_ID like '$userid'";
	}
	else if($type==2){
		$sql="select * from project where PM_ID like '$userid'";
	}

	$result=mysqli_query($conn,$sql);

	$arr = array();
	// 输出每行数据
	while($row = mysqli_fetch_assoc($result)) {
	    $count=count($row);//不能在循环语句中，由于每次删除row数组长度都减小
	    for($i=0;$i<$count;$i++){
	        unset($row[$i]);//删除冗余数据
	    }
	    array_push($arr,$row);

	}
	//print_r($arr);
	echo json_encode($arr,JSON_UNESCAPED_UNICODE);//json编码
?>
