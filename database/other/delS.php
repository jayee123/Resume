<?php
    header("Content-Type:text/html; charset=utf-8");

    if (isset($_POST["s_no"]) && isset($_POST["del"])) {
        include_once("dbtools.inc.php");
        $link = create_connection();

        $sql = "UPDATE supplier SET s_state = '停業' WHERE s_no=\"".$_POST["s_no"]."\";";
        execute_sql($link,"company",$sql);

		mysqli_close($link);
        echo "<script type='text/javascript'>";
        echo "alert('供應商編號".$_POST["s_no"]."已設為停業。');";
        echo "document.location.replace('supplier.php');";
        echo "</script>";
    }
    else
        {
            header("location:supplier.php");
        }
?>
