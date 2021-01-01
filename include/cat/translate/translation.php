<?php
    include("../../conn.php");
    $action = $_GET['action'];
    
    if($action=='confirm')
    {
        $transID=$_POST["translation_ID"];
        $srclan=$_POST["sourceText"];
        $tarlan=$_POST["targetText"];
        $update_sql = "UPDATE `translationbase`SET targetText='$tarlan' WHERE translation_ID='$transID'";
        $addTM_sql = "INSERT INTO translationmemorybase (sourceText,targertText) VALUES ('$srclan','$tarlan')";
        if(mysqli_query($conn, $update_sql)){
            
            echo $transID;
            echo $scrlan;
            echo $tarlan;
        }
        else {
            echo "error:".mysqli_error($conn);
        }
        
        if(mysqli_query($conn, $addTM_sql)){
            
            echo "chenggong";
        }
        else {
            echo "error:".mysqli_error($conn);
        }
    }
    else if($action=="addterm")
    {
        $termsheet=$_POST["termsheet"];
        $zh_CN=$_POST["zh_CN"];
        $en_US=$_POST["en_US"];
        $definition=$_POST["definition"];
        $property=$_POST["property"];
        $ts_id=mysqli_query($conn, "select termsheet_ID from termsheet where termsheet_Name='$termsheet'");

        $addterm_sql = "INSERT INTO termbase (termsheet_ID,sourceText,targetText,term_Definition,term_Property) VALUES ($ts_id,'$zh_CN','$en_US',$definition','$property')";
    }  
    
?>