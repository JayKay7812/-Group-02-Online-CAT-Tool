<?php
    include("../../conn.php");
    $action=$_GET["action"];
    if($action=="re")  //恢复部分
    {
        $id=$_POST["id"];
        $name=$_POST["name"];
        $type=$_POST["type"];
        $re_sql="DELETE from deletedfile where (deleted_ID=$id and type='$type')";
        if(!mysqli_query($conn, $re_sql)){
            
            echo "error:".mysqli_error($conn);
        }
        else {
            echo "恢复成功";
        }
    }
    else if($action=="del") //彻底删除部分
    {
        $id=$_POST["id"];
        $name=$_POST["name"];
        $type=$_POST["type"];
        if($type=="项目") //项目删除部分
        {
            $sheet_sql="select translationsheet_ID from translationsheet where project_ID = $id";
            $sheet_ID=mysqli_fetch_assoc(mysqli_query($conn, $sheet_sql));
            foreach($sheet_ID as $sheetid) //删除句段
            {
                $del_trans_sql="DELETE from translationbase where translationsheet_ID=$sheetid";
                if(!mysqli_query($conn, $del_trans_sql)){
            
                    echo "error:".mysqli_error($conn);
                }
                else {
                    echo "删除句段成功";
                }
            }

            $del_file="DELETE from translationsheet where project_ID = $id"; //删除项目内文件
            if(!mysqli_query($conn, $del_file)){
            
                echo "error:".mysqli_error($conn);
            }
            else {
                echo "删除文件成功";
            }
            
            $del_sql_1="DELETE from project where project_ID=$id"; //删除项目
            if(!mysqli_query($conn, $del_sql_1)){
            
                echo "error:".mysqli_error($conn);
            }
            else {
                echo "删除项目成功";
            }
            
        }
        else if($type=="术语") //术语删除部分
        {
            $del_term="DELETE from termbase where tbsheet_ID = $id"; //删除术语条目
            if(!mysqli_query($conn, $del_term)){
            
                echo "error:".mysqli_error($conn);
            }
            else {
                echo "删除术语条目成功";
            }
            $del_sql_1="DELETE from termsheet where tbsheet_ID=$id"; //删除术语表
            if(!mysqli_query($conn, $del_sql_1)){
            
                echo "error:".mysqli_error($conn);
            }
            else {
                echo "删除术语表成功";
            }
        }

        else if($type=="TM") //tm删除部分
        {
            $del_tm="DELETE from translationmemorybase where tmsheet_ID = $id"; //删除tm条目
            if(!mysqli_query($conn, $del_tm)){
            
                echo "error:".mysqli_error($conn);
            }
            else {
                echo "删除tm条目成功";
            }
            $del_sql_1="DELETE from translationmemorysheet where tmsheet_ID=$id"; //删除tm表
            if(!mysqli_query($conn, $del_sql_1)){
            
                echo "error:".mysqli_error($conn);
            }
            else {
                echo "删除tm表成功";
            }
        }

        else if($type=="file") //文件删除部分
        {

            $del_trans_sql="DELETE from translationbase where translationsheet_ID=$id";
            if(!mysqli_query($conn, $del_trans_sql)){
            
                echo "error:".mysqli_error($conn);
            }
            else {
                echo "删除句段成功";
            }
            $del_file="DELETE from translationsheet where translationsheet_ID = $id"; //删除项目内文件
            if(!mysqli_query($conn, $del_file)){
            
                echo "error:".mysqli_error($conn);
            }
            else {
                echo "删除文件成功";
            }
        }

        
        $del_sql_2="DELETE from deletedfile where (deleted_ID=$id and type='$type')"; //回收站更新
        if(!mysqli_query($conn, $del_sql_2)){
            
            echo "error:".mysqli_error($conn);
        }
        else {
            echo "移除成功";
        }
    }

?>
