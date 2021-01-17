<?php
    include("../../conn.php");
    $action = $_GET['action'];
    
    if($action=='confirm')
    {
        $transID=$_POST["translation_ID"];
        $srclan=$_POST["sourceText"];
        $srclan=htmlspecialchars($srclan,ENT_QUOTES);
        $tarlan=$_POST["targetText"];
        $tarlan=htmlspecialchars($tarlan,ENT_QUOTES);
        $tsid=$_POST["translationsheet_ID"];

        $update_sql = "UPDATE `translationbase`SET targetText='$tarlan' WHERE translation_ID='$transID'";
        if(mysqli_query($conn, $update_sql)){
            
            echo "更新成功";
        }
        else {
            echo "error:".mysqli_error($conn);
        }

        $check_sql="select * from translationmemorybase where (sourceText='$srclan' and targertText='$tarlan')";
        if(mysqli_query($conn, $check_sql)!==NULL)
        {
            $addTM_sql = "INSERT INTO translationmemorybase (tmsheet_ID,sourceText,targertText) VALUES ($tsid,'$srclan','$tarlan')";
            if(mysqli_query($conn, $addTM_sql)){

                echo "插入成功";
            }
            else {
                echo "error:".mysqli_error($conn);
            }
        }
        else{
            echo "有重复";
        }
    }
    else if($action=="addterm")
    {
        $termsheet=$_POST["termsheet"];
        $zh_CN=$_POST["zh_CN"];
        $en_US=$_POST["en_US"];
        $definition=$_POST["definition"];
        $property=$_POST["stopword"];
        $ts_id=mysqli_fetch_assoc(mysqli_query($conn, "select tbsheet_ID from termsheet where tbsheet_Name='$termsheet'"));
        $tb_id=$ts_id["tbsheet_ID"];
        echo $tb_id;
        $addterm_sql = "INSERT INTO termbase (tbsheet_ID,zh_CN,en_US,term_Definition,term_Property) VALUES ($tb_id,'$zh_CN','$en_US','$definition','$property')";
        
        if(mysqli_query($conn, $addterm_sql)){
            
            echo "chenggong";
        }
        else {
            echo "error:".mysqli_error($conn);
        }
    }  
    
?>