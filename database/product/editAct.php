<?php
    header('Content-Type: text/html; charset=utf-8');
    include("mysql.inc.php");

    if(isset($_POST["submit"])) {
		//若材質未填入，則改為Null
		if($_POST["fp_made"]!="")
			$fp_made = "'".$_POST["fp_made"]."'";
		else
			$fp_made = "NULL";
		
        //更新所指定編號的記錄
        $sql='UPDATE finished_product
        SET fp_name = "'.$_POST["fp_name"].'",
        fp_class = "'.$_POST["fp_class"].'",
        fp_made = '.$fp_made.',
        fp_inventory = "'.$_POST["fp_inventory"].'"
        WHERE fp_no = "'.$_POST["fp_no"].'";';
        //echo $sql;
        mysqli_query($conn, $sql);

        //修改成功訊息
		echo "<script type='text/javascript'>";
		echo "alert('編號".$_POST["fp_no"]."成品資料修改成功。');";
		echo "document.location.replace('index.php');";
		echo "</script>";
    }
    else
        header("location: index.php");
?>