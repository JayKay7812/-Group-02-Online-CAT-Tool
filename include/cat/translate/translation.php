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
<<<<<<< HEAD
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
=======
        $property=$_POST["property"];
        $ts_id=mysqli_query($conn, "select termsheet_ID from termsheet where termsheet_Name='$termsheet'");

        $addterm_sql = "INSERT INTO termbase (termsheet_ID,sourceText,targetText,term_Definition,term_Property) VALUES ($ts_id,'$zh_CN','$en_US',$definition','$property')";
>>>>>>> 1f63671a6e67a979468d40182613951addb39c21
    }  
    
?>