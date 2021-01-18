<?php
	include('conn.php');
	session_start();
	$userid=$_SESSION['userid'];
	$userid=intval($userid);
	$type = $_GET['type'];
	$translationid=$_GET['translationsheet_ID'];
	if($type==1){ //显示项目
		$sql="SELECT project_ID,project_Name,source_Language,target_Language,project_Status,due_Date FROM project 
				where (PM_ID = $userid and project_ID not in (select deleted_ID from deletedfile where `type`='项目'))";
	}
	else if($type==2){ //显示项目内待翻译文件
		$projectid = $_GET['projectid'];
		$sql="SELECT translationsheet_ID, file_Name, sourceLanguage, targetLanguage from translationsheet 
				where (project_ID=$projectid and translationsheet_ID not in (select deleted_ID from deletedfile where `type`='文件'))";
	}
	else if($type==3){ //显示句段
		$sql="select translation_ID,sourceText,targetText from translationbase where translationsheet_ID='$translationid'";
	}
	else if($type==4){ //添加术语功能下拉菜单
		$sql="select tbsheet_Name from termsheet where tbsheet_ID not in (select deleted_ID from deletedfile where `type`='术语')";
	}
	else if($type==5){ //显示翻译记忆库
		$sql="SELECT tmsheet_ID,tmsheet_Name,sourceLanguage,targetLanguage,tmsheet_Status FROM translationmemorysheet 
		where (owner_ID = $userid and tmsheet_ID not in (select deleted_ID from deletedfile where `type`='TM'))";
	}
	else if($type==6){ //显示翻译记忆库内所有翻译记忆
		$id = $_GET["id"];
		$sql="select tm_ID, sourceText, targertText from translationmemorybase where tmsheet_ID=$id";
	}
	else if($type==11){
		$sql="SELECT * FROM translationmemorysheet where tmsheet_ID not in (select deleted_ID from deletedfile where `type`='TM')";
	}
	else if($type==12){
		$sql="SELECT * FROM termsheet where tbsheet_ID not in (select deleted_ID from deletedfile where `type`='术语')";
	}
	else if($type==9){ //回收站
		$option=$_GET["option"];
		if($option=="all")
		{
			$sql="select * from deletedfile";
		}
		else if($option=="project")
		{
			$sql="select * from deletedfile where type='项目'";
		}
		else if($option=="file")
		{
			$sql="select * from deletedfile where type='文件'";
		}
		else if($option=="term")
		{
			$sql="select * from deletedfile where type='术语'";
		}
		else if($option=="tm")
		{
			$sql="select * from deletedfile where type='TM'";
		}
	}
	else if($type==7){ //显示术语库
		$sql="SELECT tbsheet_ID,tbsheet_Name,sourceLanguage,targetLanguage,tbsheet_Status FROM termsheet 
		where (owner_ID = $userid and tbsheet_ID not in (select deleted_ID from deletedfile where `type`='术语'))";
	}
	else if($type==8){ //显示术语库内所有术语
		$id = $_GET["id"];
		$sql="select term_ID, zh_CN, en_US, term_Definition from termbase where tbsheet_ID=$id";
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
	echo json_encode($return,JSON_UNESCAPED_UNICODE);//json编码
?>
