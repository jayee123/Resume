<?php
    header( 'Content-Type: text/html; charset=utf-8' );
    include("mysql.inc.php");
    //如果以 GET 方式傳遞過來的 del 參數不是空字串 且 確實存在編號為 del 的物料訂單
    if ( isset($_GET["del"])  and mysqli_num_rows(mysqli_query($conn,"SELECT rm_order_no FROM raw_material_order WHERE rm_order_no = '".$_GET["del"]."';"))){
        $process_del = "";
		$fpp_record = mysqli_fetch_assoc(mysqli_query($conn,"SELECT fpp_no FROM finished_product_process WHERE rm_order_no = '".$_GET["del"]."';"));
        if($fpp_record) {
			$fpp_no = $fpp_record["fpp_no"];
            $process_del = "，\\n並刪除編號為".$fpp_no."的加工紀錄";
		}
        //將 del 參數所指定的編號的記錄刪除
        $sql='DELETE FROM raw_material_order WHERE rm_order_no = "'.$_GET["del"].'"';
        mysqli_query($conn, $sql);
        //取得被刪除的記錄筆數

        echo "<script type='text/javascript'>";
        echo "alert('編號".$_GET["del"]."物料訂單紀錄刪除成功".$process_del."。');";
        echo "document.location.replace('o_index.php');";
        echo "</script>";
    }
    else
        header("Location: o_index.php");
?>