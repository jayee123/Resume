<?php 
include_once("dbtools.inc.php");
$link = create_connection();

if(isset($_POST["submit"])) {
		$sql = "SELECT rm_order_no FROM raw_material_order WHERE rm_order_no='".$_POST["rm_order_no"]."';";
		if(mysqli_num_rows(execute_sql($link,"company",$sql))) {
			echo "<script type='text/javascript'>";
			echo "alert('物料訂單編號重複，請重新輸入。');";
			echo "document.location.replace('".basename(__FILE__)."');";
			echo "</script>";
		}
		else {
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
				$rm_order_time = substr($_POST["rm_order_time"],0,10)." ".substr($_POST["rm_order_time"],11,5).":00";
				$sql = "INSERT INTO raw_material_order (rm_order_no,rm_order_time,rm_order_Tprice,rm_order_deadline,rm_order_state,s_no,st_no)
						VALUES ('".$_POST["rm_order_no"]."','".$rm_order_time."','".$_POST["rm_order_Tprice"]."','".$_POST["rm_order_deadline"]."','待出貨',
						'".$_POST["s_no"]."','".$_POST["rmo_st_no"]."');";
				execute_sql($link,"company",$sql);
				for($i=1;$i<=$_POST["rm_quantity"];$i++) {
					$sql = "INSERT INTO raw_material_order_record (rm_order_no,rm_no,rm_quantity,rm_Uprice) VALUES ('".$_POST["rm_order_no"]."','".$_POST["rm_no".$i]."',
							'".$_POST["rm_Q".$i]."','".$_POST["rm_Uprice".$i]."');";
					execute_sql($link,"company",$sql);
				}
				echo "<script type='text/javascript'>";
				echo "alert('成功新增物料訂單。');";
				echo "document.location.replace('o_detail.php?rm_order_no=".$_POST["rm_order_no"]."');";
				echo "</script>";
				echo "success";
			}
			else {
				echo "<script type='text/javascript'>";
				echo "alert('訂單品項有重複物料，請重新輸入。');";
				echo "document.location.replace('".basename(__FILE__)."');";
				echo "</script>";
			}
		}
}

function echo_rm_order_form($link) {
	mysqli_select_db($link,"company");
	echo "<tr class='title'><td>物料訂單編號</td><td>採購人</td><td>供應商</td><td>訂單時間</td><td>交貨日期</td></tr>";
	echo "<tr><td><input type='text' name='rm_order_no' id='no' maxlength='8' required></td><td><select name='rmo_st_no' required>";
	$staff = mysqli_query($link,"SELECT st_no, st_name FROM staff WHERE st_state = '就職中' ORDER BY st_no ASC;");
	while($row = mysqli_fetch_assoc($staff)) {
		echo "<option value='".$row["st_no"]."'>".$row["st_no"]."-".$row["st_name"]."</option>";
	}
	echo "</select></td><td><select name='s_no' required>";
	$supplier = mysqli_query($link,"SELECT s_no, s_name FROM supplier WHERE s_state = '營業中' ORDER BY s_no ASC;");
	while($row = mysqli_fetch_assoc($supplier)) {
		echo "<option value='".$row["s_no"]."'>".$row["s_no"]."-".$row["s_name"]."</option>";
	}
	echo "</select></td>";
	date_default_timezone_set("Asia/Taipei");
	echo "<td><input type='datetime-local' name='rm_order_time' value='".date("Y-m-d\TH:i")."' required></td>";
	echo "<td><input type='date' name='rm_order_deadline' required></td>";
	echo "</tr>";
	echo "<tr height='75px'><td colspan='2'><b>進貨品項</b>　";
	echo "<button type='button' class='minus' onclick='rm_minus(event)' id='mq'>-</button>　";
	echo "<input type='text' name='rm_quantity' value='1' class='value' id='rm_value_q' oninput='rm_input_check(event)' onporpertychange='rm_input_check(event)' required>　";
	echo "<button type='button' class='plus' onclick='rm_plus(event)' id='pq'>+</button></td></tr>";
}

function echo_rm_order_record($link) {
	echo "<tr class='title'><td>物料</td><td>數量</td><td>單價</td></tr>";
	$rm_select = "<select name='rm_no1' required>".echo_rm_select($link)."</select>";
	echo "<tr><td>".$rm_select."</td>";
	echo "<td><button type='button' class='minus' onclick='rm_minus(event)' id='Qm1'>-</button>　";
	echo "<input type='text' name='rm_Q1' value='' style='width:100px;' class='value' id='rm_Qvalue_1' oninput='rm_input_check(event)' onporpertychange='input_check(event)' required>　";
	echo "<button type='button' class='plus' onclick='rm_plus(event)' id='Qp1'>+</button></td>";
	
	echo "<td><button type='button' class='minus' onclick='rm_minus(event)' id='Um1'>-</button>　";
	echo "<input type='text' name='rm_Uprice1' value='' style='width:100px;' class='value' id='rm_Uvalue_1' oninput='rm_input_check(event)' onporpertychange='input_check(event)' required>　";
	echo "<button type='button' class='plus' onclick='rm_plus(event)' id='Up1'>+</button></td>";
	
	echo "</tr>";
	echo "<tr><td colspan='2' class='title'>合計</td><td><div id='rm_price'><input type='hidden' name='rm_order_Tprice' value='' required>0</div></td></tr>";
}

function echo_rm_select($link) {
	$rm_select = "";
	$raw_material = mysqli_query($link,"SELECT rm_no, rm_name FROM raw_material WHERE rm_state = '使用中' ORDER BY rm_no ASC;");
	while($row = mysqli_fetch_assoc($raw_material)) {
		$rm_select .= "<option value='".$row["rm_no"]."'>".$row["rm_no"]."-".$row["rm_name"]."</option>";
	}
	return $rm_select;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>新增物料訂單</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php echo basename(__FILE__)?>" method="post">
	<div class="fun">		
			<table width="90%" style="margin:0 auto;">
				<tr>
					<td width="60%" style="text-align:center;"><b>新增物料訂單</b></td>
					<td width="10%"><div><a href="o_index.php">回首頁</div></td>
					<td>
						<div width="30%" class="new_btn"><button type='submit' name="submit"><img src="pencil.png" heigth="25px" width="25px">確認</button></div>
					</td>
				</tr>
			</table>
		
	</div>
	
	<table class='mytable'>
	<?php
		echo_rm_order_form($link);
	?>
	</table>

	<table id='raw_material_record' class="mytable">
	<?php
		echo_rm_order_record($link);
	?>
	</table>
</form>

<script type='text/javascript'>
function rm_plus(e) {
	var target = "";
	if(e.target.id[0]=="U")
		target = "rm_Uvalue_"+e.target.id[2];
	else if(e.target.id[0]=="Q")
		target = "rm_Qvalue_"+e.target.id[2];
	else
		target = "rm_value_"+e.target.id[1];
	var currentVal = parseInt(document.getElementById(target).value);
	document.getElementById(target).value = currentVal + 1;
	rm_input_check(target);
}
function rm_minus(e) {
	var target = "";
	if(e.target.id[0]=="U")
		target = "rm_Uvalue_"+e.target.id[2];
	else if(e.target.id[0]=="Q")
		target = "rm_Qvalue_"+e.target.id[2];
	else
		target = "rm_value_"+e.target.id[1];
	var currentVal = parseInt(document.getElementById(target).value);
	if (currentVal-1>0)
		document.getElementById(target).value = currentVal - 1;
	rm_input_check(target);
}
function rm_input_check(e) {
	if(typeof(e)=="string")
		var target = e;
	else
		var target = e.target.id;
	var currentVal = document.getElementById(target).value;
	if (!Number(currentVal)) {
		document.getElementById(target).value = 1;
	}

	if(target.slice(-1)=="q") {
		var now = parseInt(document.getElementById(target).value);
		
		var target = document.getElementById("raw_material_record");
		var result = "<tr class='title'><td>物料</td><td>數量</td><td>單價</td></tr>";
		for(i=1;i<=now;i++) {
			result += "<tr><td><select name='rm_no"+i+"' required><?php echo echo_rm_select($link);?></select></td><td><button type='button' class='minus' onclick='rm_minus(event)' id='Qm"+i+"'>-</button>　<input type='text' name='rm_Q"+i+"' value='' style='width:100px;' class='value' id='rm_Qvalue_"+i+"' oninput='rm_input_check(event)' onporpertychange='input_check(event)' required>　<button type='button' class='plus' onclick='rm_plus(event)' id='Qp"+i+"'>+</button></td><td><button type='button' class='minus' onclick='rm_minus(event)' id='Um"+i+"'>-</button>　<input type='text' name='rm_Uprice"+i+"' value='' style='width:100px;' class='value' id='rm_Uvalue_"+i+"' oninput='rm_input_check(event)' onporpertychange='input_check(event)' required>　<button type='button' class='plus' onclick='rm_plus(event)' id='Up"+i+"'>+</button></td></tr>";
		}
		result += "<tr><td colspan='2' class='title'>合計</td><td><div id='rm_price'><input type='hidden' name='rm_order_Tprice' value='' required>0</div></td></tr>";;
		target.innerHTML = result;
	}
	else {
		var now = parseInt(document.getElementById("rm_value_q").value);
		
		var target = document.getElementById("rm_price");
		var result = 0;
		var plus = 0;
		for(i=1;i<=now;i++) {
			plus = parseFloat(document.getElementById("rm_Uvalue_"+i).value) * parseInt(document.getElementById("rm_Qvalue_"+i).value);
			if(!Number(plus))
				plus = 0;
			result += plus;
		}
		target.innerHTML = "<input type='hidden' name='rm_order_Tprice' value="+result+" required>"+result;
	}
}
</script>
</body>
</html>


