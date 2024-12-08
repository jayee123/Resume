<?php
    header("Content-Type:text/html; charset=utf-8");

    if (isset($_POST["st_no"]) && isset($_POST["del"])) {
        include_once("dbtools.inc.php");
        $link = create_connection();

        $sql = "UPDATE staff SET st_state = '離職' WHERE st_no=\"".$_POST["st_no"]."\";";
        execute_sql($link,"company",$sql);

		mysqli_close($link);
        echo "<script type='text/javascript'>";
        echo "alert('採購人編號".$_POST["st_no"]."已設為離職。');";
        echo "document.location.replace('staff.php');";
        echo "</script>";
    }
    else
        {
            header("location:staff.php");
        }
?>
