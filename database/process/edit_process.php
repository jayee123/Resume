<?php
	include_once("dbtools.inc.php");
	$link = create_connection();
	if (isset($_POST["submit"])) {
		if($_POST["origin_no"]!=$_POST["fpp_no"]) {
			$check = mysqli_num_rows(execute_sql($link,"company","SELECT fpp_no FROM finished_product_process WHERE fpp_no='".$_POST["fpp_no"]."';"));
			if($check) {
				echo "<script type='text/javascript'>";
				echo "alert('修改之加工編號重複，因此無法編輯，請重新輸入。');";
				echo "document.location.replace('p_content.php?fpp_no=".$_POST["origin_no"]."');";
				echo "</script>";
			}
		}
		
		$sql = "UPDATE finished_product_process SET fpp_no='".$_POST["fpp_no"]."', fp_no='".$_POST["fp_no"]."', p_Tprice='".$_POST["p_Tprice"]."', fp_finished_quantity='".$_POST["fp_finished_quantity"]."' WHERE fpp_no='".$_POST["origin_no"]."';";
		execute_sql($link,"company",$sql);
		$count = mysqli_num_rows(execute_sql($link,"company","SELECT sp_num FROM sub_process WHERE fpp_no='".$_POST["fpp_no"]."';"));
		$check = False;
		for($i=1;$i<=$count;$i++) {
			$sql = "UPDATE sub_process SET p_no='".$_POST["p_no".$i]."', p_quantity='".$_POST["p_quantity".$i]."', p_Uprice='".$_POST["p_Uprice".$i]."',
					p_deadline='".$_POST["p_deadline".$i]."', p_state='".$_POST["p_state".$i]."', p_loss='".$_POST["p_loss".$i]."' 
					WHERE fpp_no='".$_POST["fpp_no"]."' and sp_num='".$i."';";
			execute_sql($link,"company",$sql);
			if($_POST["p_content".$i]!="") {
				$sql = "UPDATE sub_process SET p_content='".$_POST["p_content".$i]."' WHERE fpp_no='".$_POST["fpp_no"]."' and sp_num='".$i."';";
				execute_sql($link,"company",$sql);
			}
			else {
				$sql = "UPDATE sub_process SET p_content=NULL WHERE fpp_no='".$_POST["fpp_no"]."' and sp_num='".$i."';";
				execute_sql($link,"company",$sql);
			}
			
			if($_POST["p_state".$i]=="完成" or $_POST["p_state".$i]=="加工中")
				$check = True;
		}
		$rmo_content = "";
		if($check) {
			$rm_order_no = $_POST["rm_order_no"];
			if(mysqli_fetch_assoc(execute_sql($link,"company","SELECT rm_order_state FROM raw_material_order WHERE rm_order_no='".$rm_order_no."';"))["rm_order_state"]!="完成") {
				$sql = "UPDATE raw_material_order SET rm_order_state = '完成' WHERE rm_order_no = '".$rm_order_no."';";
				execute_sql($link,"company",$sql);
				$rmo_content = "，並將物料編號為".$rm_order_no."的狀態更新為完成";
			}
		}
		echo "<script type='text/javascript'>";
		echo "alert('編輯成功".$rmo_content."。');";
		echo "document.location.replace('p_content.php?fpp_no=".$_POST["fpp_no"]."');";
		echo "</script>";
	}
	
	if (!isset($_POST["fpp_no"]))
		header("Location:process.php");
	
	$sql = "";
	$sql = "SELECT a.*,b.* FROM finished_product_process as a, sub_process as b WHERE a.fpp_no='".$_POST["fpp_no"]."' and b.fpp_no='".$_POST["fpp_no"]."';";
	$p_content = execute_sql($link,"company",$sql);
	
	if(!mysqli_num_rows($p_content))
		header("Location:process.php");
	
	$sql = "SELECT p_no, p_name FROM processor WHERE p_state='營業中' ORDER BY p_no;";
	$p = execute_sql($link,"company",$sql);
	$select_P = "";
	while($row = mysqli_fetch_assoc($p)) {
		$select_P .="<option value='".$row["p_no"]."'>".$row["p_no"]."-".$row["p_name"]."</option>";
	}
	
	$sql = "SELECT fp_no, fp_name FROM finished_product WHERE fp_state='販售中' ORDER BY fp_no;";
	$fp = execute_sql($link,"company",$sql);
	$select_FP = "";
	while($row = mysqli_fetch_assoc($fp)) {
		$select_FP .="<option value='".$row["fp_no"]."'>".$row["fp_no"]."-".$row["fp_name"]."</option>";
	}

	$select_state = "<option value='材料未運達'>材料未運達</option>
					 <option value='加工中'>加工中</option>
					 <option value='完成'>完成</option>";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>編輯加工訂單</title>
	<link href="table.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
		/** 價格確認 **/
		function plus(e) {
			var target = e.target;
			var id;
			if(target.id[0]=="o")
				id = "value_o";
			else
				id = target.id[0]+"value_"+target.id[1];

			var currentVal = parseInt(document.getElementById(id).value);
			document.getElementById(id).value = currentVal + 1;
			input_check(id);
		}
		function minus(e) {
			var target = e.target;
			var id;
			if(target.id[0]=="o")
				id = "value_o";
			else
				id = target.id[0]+"value_"+target.id[1];

			var currentVal = parseInt(document.getElementById(id).value);
			if (currentVal-1>0)
				document.getElementById(id).value = currentVal - 1;
			input_check(id);
		}
		function input_check(e) {
			if(typeof(e)=="string")
				var target = e;
			else
				var target = e.target.id;
			var currentVal = document.getElementById(target).value;
			if (!Number(currentVal)) {
				document.getElementById(target).value = 1;
				currentVal = 1;
			}
	
			if(target.slice(-1)!="o") {
				var finished_quantity = parseInt(document.getElementById("value_o").value);
				if(target[0]=="Q")
					if(currentVal > finished_quantity) 
						document.getElementById(target).value = finished_quantity;
				input_q_check("loss_"+target.slice(-1));

				price_change();
			}
			else if(target.slice(-1)=="o") {
				var now = <?php echo mysqli_num_rows($p_content)?>;
				for(i=1;i<=now;i++) {
					document.getElementById("Qvalue_"+i).value = currentVal;
					input_q_check("loss_"+i);
					
				}
				price_change();
			}
		}
		
		function price_change() {
			var now = <?php echo mysqli_num_rows($p_content)?>;
			var target = document.getElementById("price");
			var result = 0;
			var plus = 0;
			for(i=1;i<=now;i++) {
				plus = parseInt(document.getElementById("Qvalue_"+i).value) * parseFloat(document.getElementById("Uvalue_"+i).value);
				if(!Number(plus))
					plus = 0;
				result += plus;
			}
			target.innerHTML = "<input type='hidden' name='p_Tprice' value="+result+" required>"+result;
		}

		/** 損耗量確認 **/
		function q_plus(e) {
			var target = e.target;
			var id = "loss_"+target.id[0];;
			var currentVal = parseInt(document.getElementById(id).value);
			document.getElementById(id).value = currentVal + 1;
			input_q_check(id);
		}
		function q_minus(e) {
			var target = e.target;
			var id = "loss_"+target.id[0];;
			var currentVal = parseInt(document.getElementById(id).value);
			if (currentVal-1>=0)
				document.getElementById(id).value = currentVal - 1;
			input_q_check(id);
		}
		function input_q_check(e) {
			if(typeof(e)=="string")
				var target = e;
			else
				var target = e.target.id;
			var currentVal = document.getElementById(target).value;
			if (!Number(currentVal)) {
				document.getElementById(target).value = 0;
			}
			
			var finished_quantity = parseInt(document.getElementById("Qvalue_"+target.slice(-1)).value);
			if (currentVal > finished_quantity) {
					document.getElementById(target).value = finished_quantity;
			}
		}
		function date_change(e) {
			var now = <?php echo mysqli_num_rows($p_content)?>;
			var occur = e.target;
			var occur_v = e.target.value;
			var i = parseInt(occur.name.slice(-1))+1;
			try {
				document.getElementsByName("p_deadline"+i)[0].min = occur_v;
			}
			catch (e) {}
			for(i=(parseInt(occur.name.slice(-1))+1);i<=now;i++) {
					// 時間小則不重置
					if(occur_v>document.getElementsByName("p_deadline"+i)[0].value) {
						document.getElementsByName("p_deadline"+i)[0].min = occur_v;
						document.getElementsByName("p_deadline"+i)[0].value = "";
					}
			}
		}
		function select_change(e) {
			var id = "state_"+e.target.name.slice(-1);
			var state = e.target.value;
			var state_class = {"材料未運達":"none","加工中":"ing","完成":""}
			document.getElementById(id).setAttribute("class",state_class[state]);
			
			function state_none() {
				var now = <?php echo mysqli_num_rows($p_content)?>;
				for(i=now;i>=parseInt(e.target.name.slice(-1))+1;i--) {
					state_change_class(i,"材料未運達")
				}
			}
			function state_finish() {
				for(i=1;i<=parseInt(e.target.name.slice(-1))-1;i++) {
					state_change_class(i,"完成")
				}
			}
			function state_change_class(n,s) {
				if(n<=<?php echo mysqli_num_rows($p_content)?>) {
					document.getElementsByName("p_state"+n)[0].value = s;
					var i = "state_"+n;
					document.getElementById(i).setAttribute("class",state_class[s]);
				}
			}

			if(state == "材料未運達") {
				state_none();
				if(parseInt(id.slice(-1))-1 >= 1)
					state_change_class(parseInt(id.slice(-1))-1,"加工中")
			}
			else if(state == "加工中") {
				state_finish()
				state_none();
			}
			else {
				state_finish()
				state_change_class(parseInt(id.slice(-1))+1,"加工中")
			}
		}
	</script>
</head>
<body>
<form action="<?php echo basename(__FILE__)?>" method="post">
<input type="hidden" name="origin_no" value="<?php echo $_POST["fpp_no"]?>">
	<div class="fun">
			<table width="90%" style="margin:0 auto;"">
				<tr>
					<td width="60%" style="text-align:center;"><b>編輯加工訂單</b></td>
					<td width="10%"><div><a href="p_content.php?fpp_no=<?php echo $_POST["fpp_no"]?>">返回</div></td>
					<td>
						<div style="width:25%;" class="new_btn"><button type="submit" name="submit"><img src="pencil.png" heigth="25px" width="25px">編輯確認</button></div>
					</td>
				</tr>
			</table>
	</div>
	<?php
		$state_class = array("材料未運達"=>"none","加工中"=>"ing","完成"=>"");
		echo "<table class='mytable'>\n";
		$st_no = mysqli_fetch_assoc($p_content)["st_no"];
		$staff = mysqli_fetch_assoc(execute_sql($link,"company","SELECT * FROM staff WHERE st_no = '".$st_no."'"));
		echo "<tr><td colspan='8'><b>加工編號---<input type='text' name='fpp_no' maxlength='8' size='9' value='".$_POST["fpp_no"]."' required></b>　採購人：".$staff["st_no"]."-".$staff["st_name"]."</td></tr>\n";
		echo "<tr class='title'><td>加工順序</td><td>加工廠商</td><td>數量</td><td>單價</td><td>加工期限</td><td>狀態</td><td>損耗量</td><td>備註</td></tr>\n";
		$before_date = "";
		mysqli_data_seek($p_content, 0);
		while($row = mysqli_fetch_assoc($p_content)) {
			$p_no = $row["p_no"];
			$sql = "SELECT p_no,p_name FROM processor WHERE p_no = '".$p_no."'";
			$processor = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
			echo "<tr>
				 <td><input type='hidden' name='sp_num".$row["sp_num"]."' value='".$row["sp_num"]."'>".$row["sp_num"]."</td>
				 <td><select name='p_no".$row["sp_num"]."' required>".str_replace("value='".$row["p_no"]."'","value='".$row["p_no"]."' selected",$select_P)."</select></td>
				 <td>
					<button type='button' class='minus' onclick='minus(event)' id='Q".$row["sp_num"]."m'>-</button>
					<input type='text' name='p_quantity".$row["sp_num"]."' value='".$row["p_quantity"]."' style='width:100px;' class='value' id='Qvalue_".$row["sp_num"]."' oninput='input_check(event)' onporpertychange='input_check(event)' required>
					<button type='button' class='plus' onclick='plus(event)' id='Q".$row["sp_num"]."p'>+</button>
				 </td>
				 <td>
					<button type='button' class='minus' onclick='minus(event)' id='U".$row["sp_num"]."m'>-</button>
					<input type='text' name='p_Uprice".$row["sp_num"]."' value='".$row["p_Uprice"]."' style='width:100px;' class='value' id='Uvalue_".$row["sp_num"]."' oninput='input_check(event)' onporpertychange='input_check(event)' required>
					<button type='button' class='plus' onclick='plus(event)' id='U".$row["sp_num"]."p'>+</button>
				 </td>
				 <td><input type='date' name='p_deadline".$row["sp_num"]."' value='".$row["p_deadline"]."' min='".$before_date."' oninput='date_change(event)' onporpertychange='date_change(event)' required></td>
				 <td class='".$state_class[$row["p_state"]]."' id='state_".$row["sp_num"]."'>
				 	<select name='p_state".$row["sp_num"]."' oninput='select_change(event)' onporpertychange='select_change(event)' required>"
					 .str_replace("value='".$row["p_state"]."'","value='".$row["p_state"]."' selected",$select_state).
					"</select>
				 </td>
				 <td>
					<button type='button' class='minus' onclick='q_minus(event)' id='".$row["sp_num"]."l'>-</button>
					<input type='text' name='p_loss".$row["sp_num"]."' value='".$row["p_loss"]."' style='width:100px;' class='value' id='loss_".$row["sp_num"]."' oninput='input_q_check(event)' onporpertychange='input_q_check(event)' required>
					<button type='button' class='plus' onclick='q_plus(event)' id='".$row["sp_num"]."l'>+</button>
				 </td>
				 <td><input type='text' name='p_content".$row["sp_num"]."' value='".$row["p_content"]."' size='8' maxlength='6'></td>
				 </tr>\n";
			$before_date = $row["p_deadline"];
		}
		echo "</table>\n";
		
		$sql = "SELECT fp_name,b.* FROM finished_product as a,finished_product_process as b WHERE a.fp_no = b.fp_no and fpp_no = '".$_POST["fpp_no"]."';";
		$fpp = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
		echo "<table class='mytable'>\n";
		echo "<tr class='title'><td>製作成品</td><td>預計完成量</td><td>加工總花費</td><td>委託時間</td><td>物料來源編號</td></tr>\n";	
		echo "<tr><td><select name='fp_no' required>".str_replace("value='".$fpp["fp_no"]."'","value='".$fpp["fp_no"]."' selected",$select_FP)."</select></td>
			  <td>
				<button type='button' class='minus' onclick='minus(event)' id='om'>-</button>
				<input type='text' name='fp_finished_quantity' value='".$fpp["fp_finished_quantity"]."' style='width:100px;' class='value' id='value_o' oninput='input_check(event)' onporpertychange='input_check(event)' required>
				<button type='button' class='plus' onclick='plus(event)' id='op'>+</button>
			  </td>
			  <td><div id='price'><input type='hidden' name='p_Tprice' value='".$fpp["p_Tprice"]."' required>".$fpp["p_Tprice"]."</div></td>
			  <td>".$fpp["fpp_time"]."</td><td>".$fpp["rm_order_no"]."<input type='hidden' name='rm_order_no' value='".$fpp["rm_order_no"]."'></td></tr>\n";
		echo "</table>";
		
		$sql = "SELECT * FROM raw_material_order_record WHERE rm_order_no = '".$fpp["rm_order_no"]."';";
		$rm = execute_sql($link,"company",$sql);
		$staff = mysqli_fetch_assoc(execute_sql($link,"company","SELECT a.st_no,a.st_name FROM staff as a, raw_material_order as b WHERE rm_order_no = '".$fpp["rm_order_no"]."' and a.st_no = b.st_no;"));
		
		echo "<table class='mytable'>\n";
		echo "<tr><td colspan='5'><b>物料訂單---".$fpp["rm_order_no"]."</b>　採購人：".$staff["st_no"]."-".$staff["st_name"]."</td></tr>\n";
		echo "<tr class='title'><td>物料</td><td>材質</td><td>數量</td><td>單價</td><td>合計</td></tr>\n";
		while($row = mysqli_fetch_assoc($rm)) {
			$sql = "SELECT rm_name,rm_made FROM raw_material WHERE rm_no = '".$row["rm_no"]."'";
			$rm_content = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
			$total = $row["rm_Uprice"]*$row["rm_quantity"];
			echo "<tr>";
			echo "<td>".$row["rm_no"]."-".$rm_content["rm_name"]."</td><td>".$rm_content["rm_made"]."</td><td>".$row["rm_quantity"]."</td><td>".$row["rm_Uprice"]."</td><td>".$total."</td>\n";
			echo "</tr>";
		}
		$sql = "SELECT * FROM raw_material_order WHERE rm_order_no = '".$fpp["rm_order_no"]."';";
		$rm_order = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
		$sql = "SELECT s_no,s_name FROM supplier WHERE s_no = '".$rm_order["s_no"]."';";
		$s = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
		echo "<tr class='title'><td>供應商</td><td width='250px'>訂單時間</td><td>交貨日期</td><td>訂單狀態</td><td>總價</td></tr>\n";
		echo "<tr><td>".$s["s_no"]."-".$s["s_name"]."</td><td>".$rm_order["rm_order_time"]."</td><td>".$rm_order["rm_order_deadline"]."</td><td>".
		$rm_order["rm_order_state"]."</td><td>".$rm_order["rm_order_Tprice"]."</td></tr>\n";
		echo "</table>\n";
		mysqli_close($link);
	?>
</form>
<form action="delProcess.php" method="post" id="del">
	<div class="new_btn" style="width:75px; margin:50px auto; background-color: #FF8F59;"><button type="button" style="background-color: #FF8F59;" onclick="check()"><img src="pencil.png" heigth="25px" width="25px">刪除</button></div>
	<input type="hidden" name="fpp_no" value="<?php echo $_POST["fpp_no"]; ?>">
	<input type="hidden" name="del" value="del" >
</form>
<script type="text/javascript">
	function check() {
		if (confirm('確定要刪除加工編號為<?php echo $_POST["fpp_no"];?>的紀錄嗎？') == true) {
			document.getElementById('del').submit();
		}
	}
</script>
</body>
</html>