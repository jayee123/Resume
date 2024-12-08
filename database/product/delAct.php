<?php
    header( 'Content-Type: text/html; charset=utf-8' );
    include("mysql.inc.php");

    //如果以 GET 方式傳遞過來的 del 參數不是空字串
    if ( isset($_POST["del"]) ){

		//將 del 參數所指定的編號的記錄刪除
		$sql='UPDATE finished_product SET fp_state = "停賣" WHERE fp_no = "'.$_POST["del"].'"';
		//echo $sql;
		mysqli_query($conn, $sql);

		//刪除成功訊息
		echo "<script type='text/javascript'>";
		echo "alert('編號".$_POST["del"]."成品刪除(設為停賣)成功。');";
		echo "document.location.replace('index.php');";
		echo "</script>";
	}
	else
		header("location:index.php");
?>