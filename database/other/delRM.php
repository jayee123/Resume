<?php
    header("Content-Type:text/html; charset=utf-8");

    if (isset($_POST["rm_no"]) && isset($_POST["del"])) {
        include_once("dbtools.inc.php");
        $link = create_connection();

        $sql = "UPDATE raw_material SET rm_state = '停用' WHERE rm_no=\"".$_POST["rm_no"]."\";";
        execute_sql($link,"company",$sql);

		mysqli_close($link);
        echo "<script type='text/javascript'>";
        echo "alert('物料編號".$_POST["rm_no"]."已設為停用。');";
        echo "document.location.replace('raw_material.php');";
        echo "</script>";
    }
    else
        {
            header("location:raw_material.php");
        }
?>
