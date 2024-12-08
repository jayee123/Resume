<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

//如果以 POST 方式submit過來的
if ( isset($_POST['submit'])){
	//如果填入的編號和原來的不同，檢查是否有重複編號的資料
	if($_POST["origin_rm_order_no"]!=$_POST["rm_order_no"]) {
		$check = mysqli_num_rows(mysqli_query($conn,"SELECT rm_order_no FROM raw_material_order WHERE rm_order_no='".$_POST["rm_order_no"]."';"));
		//$check有值代表有重複編號，不能編輯
		if($check) {
			echo "<script type='text/javascript'>";
			echo "alert('修改之物料訂單編號重複，因此無法編輯，請重新輸入。');";
			echo "document.location.replace('o_edit.php?edit=".$_POST["origin_rm_order_no"]."');";
			echo "</script>";
		}
	}
	$record_ok = True;
	$record_list = array();
	for($i=1; $i<=$_POST["rm_quantity"]; $i++) {
		if(in_array($_POST["rm_no".$i], $record_list)) {
			$record_ok = False;
			break;
		}
		else
			array_push($record_list, $_POST["rm_no".$i]);
	}
	
	if($record_ok) {
		//更新所指定編號的記錄
		$sql = "UPDATE raw_material_order SET rm_order_no = '".$_POST["rm_order_no"]."', st_no = '".$_POST["st_no"]."', 
				s_no = '".$_POST["s_no"]."', rm_order_Tprice = '".$_POST["rm_order_Tprice"]."', rm_order_deadline = '".$_POST["rm_order_deadline"]."', 
				rm_order_state = '".$_POST["rm_order_state"]."'
				WHERE rm_order_no='".$_POST["origin_rm_order_no"]."';";
		mysqli_query($conn,$sql);
		
		//先刪除全部訂單細項
		$sql = "DELETE FROM raw_material_order_record WHERE rm_order_no = '".$_POST["rm_order_no"]."';";
		mysqli_query($conn,$sql);
		
		//新增(編輯)訂單細項
		$count = $_POST["rm_quantity"];
		for($i=1;$i<=$count;$i++) {
			$sql = "INSERT INTO raw_material_order_record (rm_order_no,rm_no,rm_quantity,rm_Uprice) VALUES ('".$_POST["rm_order_no"]."','".$_POST["rm_no".$i]."',
					'".$_POST["rm_Q".$i]."','".$_POST["rm_Uprice".$i]."');";
			mysqli_query($conn,$sql);
		}
		
		//顯示編輯成功訊息，並轉向o_detail網頁
		echo "<script type='text/javascript'>";
		echo "alert('物料訂單編輯成功。');";
		echo "document.location.replace('o_detail.php?rm_order_no=".$_POST["rm_order_no"]."');";
		echo "</script>";
	}
	else {
		echo "<script type='text/javascript'>";
		echo "alert('訂單品項有重複物料，請重新輸入。');";
		echo "document.location.replace('o_edit.php?edit=".$_POST["origin_rm_order_no"]."');";
		echo "</script>";
	}
}
?>