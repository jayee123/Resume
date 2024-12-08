<?php
    header("Content-Type:text/html; charset=utf-8");

    if (isset($_POST["fpp_no"]) && isset($_POST["del"])) {
        include_once("dbtools.inc.php");
        $link = create_connection();

        $sql = "DELETE FROM finished_product_process WHERE fpp_no=\"".$_POST["fpp_no"]."\";";
        execute_sql($link,"company",$sql);

		mysqli_close($link);
        echo "<script type='text/javascript'>";
        echo "alert('加工編號".$_POST["fpp_no"]."紀錄刪除成功。');";
        echo "document.location.replace('process.php');";
        echo "</script>";
    }
    else
        {
            header("Location:process.php");
        }
?>
