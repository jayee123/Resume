<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

//如果以 POST 方式submit過來的
if ( isset($_POST['submit'])){
	//如果填入的編號和原來的不同，檢查是否有重複編號的資料
	if($_POST["origin_fp_order_no"]!=$_POST["fp_order_no"]) {
		$check = mysqli_num_rows(mysqli_query($conn,"SELECT fp_order_no FROM finished_product_order WHERE fp_order_no='".$_POST["fp_order_no"]."';"));
		//$check有值代表有重複編號，不能編輯
		if($check) {
			echo "<script type='text/javascript'>";
			echo "alert('修改之成品訂單編號重複，因此無法編輯，請重新輸入。');";
			echo "document.location.replace('f_edit.php?edit=".$_POST["origin_fp_order_no"]."');";
			echo "</script>";
		}
	}

	$record_ok = True;
	$record_list = array();
	for($i=1; $i<=$_POST["fp_quantity"]; $i++) {
		if(in_array($_POST["fp_no".$i], $record_list)){
			$record_ok = False;
			break;
		}
		else
			array_push($record_list, $_POST["fp_no".$i]);
	}
	if($record_ok) {
	//更新所指定編號的記錄
		$sql = "UPDATE finished_product_order SET fp_order_no = '".$_POST["fp_order_no"]."', st_no = '".$_POST["st_no"]."', 
				s_no = '".$_POST["s_no"]."', fp_order_Tprice = '".$_POST["fp_order_Tprice"]."', fp_order_deadline = '".$_POST["fp_order_deadline"]."', 
				fp_order_state = '".$_POST["fp_order_state"]."'
				WHERE fp_order_no='".$_POST["origin_fp_order_no"]."';";
		mysqli_query($conn,$sql);
		
		//先刪除全部訂單細項
		$sql = "DELETE FROM finished_product_order_record WHERE fp_order_no = '".$_POST["fp_order_no"]."';";
		mysqli_query($conn,$sql);
		
		//新增(編輯)訂單細項
		$count = $_POST["fp_quantity"];
		for($i=1;$i<=$count;$i++) {
			$sql = "INSERT INTO finished_product_order_record (fp_order_no,fp_no,fp_quantity,fp_Uprice) VALUES ('".$_POST["fp_order_no"]."','".$_POST["fp_no".$i]."',
					'".$_POST["fp_Q".$i]."','".$_POST["fp_Uprice".$i]."');";
			mysqli_query($conn,$sql);
		}
		
		//顯示編輯成功訊息，並轉向f_detail網頁
		echo "<script type='text/javascript'>";
		echo "alert('成品訂單編輯成功。');";
		echo "document.location.replace('f_detail.php?fp_order_no=".$_POST["fp_order_no"]."');";
		echo "</script>";
	}
	else {
		echo "<script type='text/javascript'>";
		echo "alert('訂單品項有重複成品，請重新輸入。');";
		echo "document.location.replace('f_edit.php?edit=".$_POST["origin_fp_order_no"]."');";
		echo "</script>";
	}

}
?>