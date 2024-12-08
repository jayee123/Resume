<?php
    header( 'Content-Type: text/html; charset=utf-8' );
    include("mysql.inc.php");
    //如果以 GET 方式傳遞過來的 del 參數不是空字串 且 確實存在編號為 del 的成品訂單
    if ( isset($_GET["del"]) and mysqli_num_rows(mysqli_query($conn,"SELECT fp_order_no FROM finished_product_order WHERE fp_order_no = '".$_GET["del"]."';"))){
        //將 del 參數所指定的編號的記錄刪除
        $sql='DELETE FROM finished_product_order WHERE fp_order_no = "'.$_GET["del"].'"';
        // echo $sql;
        mysqli_query($conn, $sql);

        echo "<script type='text/javascript'>";
        echo "alert('編號".$_GET["del"]."成品訂單紀錄刪除成功。');";
        echo "document.location.replace('f_index.php');";
        echo "</script>";
    }
    else
        header("Location: f_index.php");
?>