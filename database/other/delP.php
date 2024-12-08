<?php
    header("Content-Type:text/html; charset=utf-8");

    if (isset($_POST["p_no"]) && isset($_POST["del"])) {
        include_once("dbtools.inc.php");
        $link = create_connection();

        $sql = "UPDATE processor SET p_state = '停業' WHERE p_no=\"".$_POST["p_no"]."\";";
        execute_sql($link,"company",$sql);

		mysqli_close($link);
        echo "<script type='text/javascript'>";
        echo "alert('加工商編號".$_POST["p_no"]."已設為停業。');";
        echo "document.location.replace('processor.php');";
        echo "</script>";
    }
    else
        {
            header("location:processor.php");
        }
?>
