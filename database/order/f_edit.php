<?php
    include("mysql.inc.php");
    if (isset($_GET['edit'])){
		//查詢 edit 參數所指定編號的記錄, 從資料庫將原有的資料取出
		$sql='SELECT fp_order.*, supplier.s_name, staff.st_name
		FROM finished_product_order as fp_order, supplier, staff
		WHERE fp_order.s_no = supplier.s_no AND
		fp_order.st_no = staff.st_no 
		AND fp_order_no = "'.$_GET["edit"].'"';
		//echo $sql;
		$result=mysqli_query($conn, $sql);
		if(mysqli_num_rows($result)==0) {
			//如果沒有查到指定編號紀錄，轉向主畫面
			header("Location:f_index.php");
		}
		else {
			//將查詢到的資料(只有一筆)放在 $row 陣列
			$row=mysqli_fetch_array($result);
			
			//查詢 edit 指定編號的詳細訂單記錄
			$sql = 'SELECT finished_product_order_record.* FROM finished_product_order_record WHERE fp_order_no = "'.$row['fp_order_no'].'";';
			$detail = mysqli_query($conn, $sql);
		}
	}
    else {
        //如果沒有 edit 參數, 表示此為錯誤執行, 所以轉向回主頁面
        header("Location:f_index.php");
    }

	//下拉式選單變數存放 採購人$s_staff, 供應商$s_supplier, 狀態$s_state, 成品$s_fp
	
	//查詢現任採購人，並將資料存放在$s_staff
	$s_staff = "<select name='st_no'>";
	$staff = mysqli_query($conn,"SELECT st_no, st_name FROM staff WHERE st_state = '就職中' ORDER BY st_no ASC;");
	while($s = mysqli_fetch_assoc($staff)) {
		$s_staff .= "<option value='".$s["st_no"]."'>".$s["st_no"]."-".$s["st_name"]."</option>";
	}
	$s_staff .= "</select>";
	
	//查詢現有供應商，並將資料存放在$s_supplier
	$s_supplier = "<select name='s_no'>";
	$staff = mysqli_query($conn,"SELECT s_no, s_name FROM supplier WHERE s_state = '營業中' ORDER BY s_no ASC;");
	while($s = mysqli_fetch_assoc($staff)) {
		$s_supplier .= "<option value='".$s["s_no"]."'>".$s["s_no"]."-".$s["s_name"]."</option>";
	}
	$s_supplier .= "</select>";
	
	//查詢現有成品，並將資料存放在$s_fp
	$s_fp = "";
	$fp = mysqli_query($conn,"SELECT fp_no, fp_name FROM finished_product WHERE fp_state = '販售中' ORDER BY fp_no ASC;");
	while($f = mysqli_fetch_assoc($fp)) {
		$s_fp .= "<option value='".$f["fp_no"]."'>".$f["fp_no"]."-".$f["fp_name"]."</option>";
	}
	
	$s_state = "<select name='fp_order_state'><option value='待出貨'>待出貨</option><option value='完成'>完成</option><option value='退回'>退回</option></select>"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯成品訂單</title>
	<link rel="stylesheet" type="text/css" href="table.css">
</head>
<body>
    <form action="f_editAct.php" method="post">
		<div class="fun">		
				<table width="90%" style="margin:0 auto;">
					<tr>
						<td width="60%" style="text-align:center;"><b>編輯成品訂單</b></td>
						<td width="10%"><div><a href="f_index.php">回首頁</div></td>
						<td>
							<div width="30%" class="new_btn"><button type='submit' name="submit"><img src="pencil.png" heigth="25px" width="25px">確認</button></div>
						</td>
					</tr>
				</table>
		</div>
		<table class="mytable">
		<tr class='title'><td>成品訂單編號</td><td>採購人</td><td>供應商</td><td>訂單時間</td><td>交貨日期</td><td>訂單狀態</td></tr>
		<tr>
			<td>
				<input type='text' name='fp_order_no' maxlength='8' value='<?php echo $row["fp_order_no"]?>' required>
				<input type='hidden' name='origin_fp_order_no' value='<?php echo $row["fp_order_no"]?>'> <!-- 記下原本的訂單編號 -->
			</td>
			<!-- 選取目前的訂單採購人 -->
			<td><?php echo str_replace("value='".$row["st_no"]."'","value='".$row["st_no"]."' selected",$s_staff);?></td>
			
			<!-- 選取目前的訂單供應商 -->
			<td><?php echo str_replace("value='".$row["s_no"]."'","value='".$row["s_no"]."' selected",$s_supplier);?></td>
			
			<td><?php echo $row["fp_order_time"]?></td>
			<td><input type='date' name='fp_order_deadline' value="<?php echo $row["fp_order_deadline"];?>" required></td>
			
			<!-- 選取目前的訂單狀態 -->
			<td><?php echo str_replace("value='".$row["fp_order_state"]."'","value='".$row["fp_order_state"]."' selected",$s_state);?></td>
		</tr>
		</table>
		
	<table class="mytable">
	<tr class='title'><td>成品</td><td>數量</td><td>單價</td></tr>
	<?php
		$count = 1;
		while($record = mysqli_fetch_array($detail)) {
			//選取目前詳細訂單紀錄的成品，並將對應數量及單價填入
			echo "<tr><td><select name='fp_no".$count."'>".str_replace("value='".$record["fp_no"]."'","value='".$record["fp_no"]."' selected",$s_fp)."</select></td>";
			
			echo "<td><button type='button' class='minus' onclick='fp_minus(event)' id='Qm".$count."'>-</button>　";
			echo "<input type='text' name='fp_Q".$count."' value='".$record["fp_quantity"]."' style='width:100px;' class='value' id='fp_Qvalue_".$count."'' oninput='fp_input_check(event)' onporpertychange='input_check(event)' required>　";
			echo "<button type='button' class='plus' onclick='fp_plus(event)' id='Qp".$count."''>+</button></td>";
			
			echo "<td><button type='button' class='minus' onclick='fp_minus(event)' id='Um".$count."''>-</button>　";
			echo "<input type='text' name='fp_Uprice".$count."' value='".$record["fp_Uprice"]."' style='width:100px;' class='value' id='fp_Uvalue_".$count."'' oninput='fp_input_check(event)' onporpertychange='input_check(event)' required>　";
			echo "<button type='button' class='plus' onclick='fp_plus(event)' id='Up".$count."''>+</button></td>";
			
			echo "</tr>";
			
			$count+=1;
		}
		echo "<tr><td colspan='2' class='title'>合計</td><td><div id='fp_price'><input type='hidden' name='fp_order_Tprice' value='".$row["fp_order_Tprice"]."' required>".$row["fp_order_Tprice"]."</div></td></tr>";
		echo "<input id='fp_value_q' type='hidden' name='fp_quantity' value='".mysqli_num_rows($detail)."'>";
	?>
	
	</form>
<script type='text/javascript'>
function fp_plus(e) {
	var target = "";
	if(e.target.id[0]=="U")
		target = "fp_Uvalue_"+e.target.id[2];
	else if(e.target.id[0]=="Q")
		target = "fp_Qvalue_"+e.target.id[2];
	else
		target = "fp_value_"+e.target.id[1];
	var currentVal = parseInt(document.getElementById(target).value);
	document.getElementById(target).value = currentVal + 1;
	fp_input_check(target);
}
function fp_minus(e) {
	var target = "";
	if(e.target.id[0]=="U")
		target = "fp_Uvalue_"+e.target.id[2];
	else if(e.target.id[0]=="Q")
		target = "fp_Qvalue_"+e.target.id[2];
	else
		target = "fp_value_"+e.target.id[1];
	var currentVal = parseInt(document.getElementById(target).value);
	if (currentVal-1>0)
		document.getElementById(target).value = currentVal - 1;
	fp_input_check(target);
}
function fp_input_check(e) {
	if(typeof(e)=="string")
		var target = e;
	else
		var target = e.target.id;
	var currentVal = document.getElementById(target).value;
	if (!Number(currentVal)) {
		document.getElementById(target).value = 1;
	}


	var now = document.getElementById("fp_value_q").value;
	
	var target = document.getElementById("fp_price");
	var result = 0;
	var plus = 0;
	for(i=1;i<=now;i++) {
		plus = parseFloat(document.getElementById("fp_Uvalue_"+i).value) * parseInt(document.getElementById("fp_Qvalue_"+i).value);
		if(!Number(plus))
			plus = 0;
		result += plus;
	}
	target.innerHTML = "<input type='hidden' name='fp_order_Tprice' value="+result+" required>"+result;

}
</script>
</body>
</html>