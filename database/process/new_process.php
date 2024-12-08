<?php
    include_once("dbtools.inc.php");
	include_once("new_rm_order_function.php");
    $link = create_connection();
	
	if(isset($_POST["submit"])) {
		if($_POST["rm_order"]=="new") {
			$message = "";
			$warn = "";
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
					$message = "物料訂單和";
					$warn = "成功新增物料訂單，但";
				}
				else {
					echo "<script type='text/javascript'>";
					echo "alert('物料訂單品項有重複物料，請重新輸入。');";
					echo "document.location.replace('".basename(__FILE__)."');";
					echo "</script>";
				}
			}
		
		
			$sql = "SELECT fpp_no FROM finished_product_process WHERE fpp_no='".$_POST["fpp_no"]."';";
			if(mysqli_num_rows(execute_sql($link,"company",$sql))) {
				echo "<script type='text/javascript'>";
				echo "alert('".$warn."加工編號重複，請重新輸入。');";
				echo "document.location.replace('".basename(__FILE__)."');";
				echo "</script>";
			}
			else {
				$fpp_time = substr($_POST["fpp_time"],0,10)." ".substr($_POST["fpp_time"],11,5).":00";
				$sql = "INSERT INTO finished_product_process (fpp_no,fpp_time,p_Tprice,fp_no,fp_finished_quantity,rm_order_no,st_no)
						VALUES ('".$_POST["fpp_no"]."','".$fpp_time."','".$_POST["p_Tprice"]."','".$_POST["fp_no"]."','".$_POST["fp_finished_quantity"]."',
						'".$_POST["rm_order_no"]."','".$_POST["st_no"]."');";
				execute_sql($link,"company",$sql);
				for($i=1;$i<=$_POST["p_quantity"];$i++) {
					if($_POST["p_content".$i]=="")
						$sql = "INSERT INTO sub_process (fpp_no,sp_num,p_Uprice,p_quantity,p_deadline,p_no) VALUES ('".$_POST["fpp_no"]."','".$_POST["sp_num".$i]."',
								'".$_POST["p_Uprice".$i]."','".$_POST["fp_finished_quantity"]."','".$_POST["p_deadline".$i]."','".$_POST["p_no".$i]."');";
					else
						$sql = "INSERT INTO sub_process (fpp_no,sp_num,p_Uprice,p_quantity,p_deadline,p_no,p_content) VALUES ('".$_POST["fpp_no"]."','".$_POST["sp_num".$i]."',
								'".$_POST["p_Uprice".$i]."','".$_POST["fp_finished_quantity"]."','".$_POST["p_deadline".$i]."','".$_POST["p_no".$i]."', '".$_POST["p_content".$i]."');";
					execute_sql($link,"company",$sql);
				}
				echo "<script type='text/javascript'>";
				echo "alert('成功新增".$message."加工訂單。');";
				echo "document.location.replace('p_content.php?fpp_no=".$_POST["fpp_no"]."');";
				echo "</script>";
			}
		}
		else if($_POST["rm_order"]=="old") {
			$sql = "SELECT fpp_no FROM finished_product_process WHERE fpp_no='".$_POST["fpp_no"]."';";
			if(mysqli_num_rows(execute_sql($link,"company",$sql))) {
				echo "<script type='text/javascript'>";
				echo "alert('加工編號重複，請重新輸入。');";
				echo "document.location.replace('".basename(__FILE__)."');";
				echo "</script>";
			}
			else {
				$fpp_time = substr($_POST["fpp_time"],0,10)." ".substr($_POST["fpp_time"],11,5).":00";
				$sql = "INSERT INTO finished_product_process (fpp_no,fpp_time,p_Tprice,fp_no,fp_finished_quantity,rm_order_no,st_no)
						VALUES ('".$_POST["fpp_no"]."','".$fpp_time."','".$_POST["p_Tprice"]."','".$_POST["fp_no"]."','".$_POST["fp_finished_quantity"]."',
						'".$_POST["rm_order_no"]."','".$_POST["st_no"]."');";
				execute_sql($link,"company",$sql);
				for($i=1;$i<=$_POST["p_quantity"];$i++) {
					if($_POST["p_content".$i]=="")
						$sql = "INSERT INTO sub_process (fpp_no,sp_num,p_Uprice,p_quantity,p_deadline,p_no) VALUES ('".$_POST["fpp_no"]."','".$_POST["sp_num".$i]."',
								'".$_POST["p_Uprice".$i]."','".$_POST["fp_finished_quantity"]."','".$_POST["p_deadline".$i]."','".$_POST["p_no".$i]."');";
					else
						$sql = "INSERT INTO sub_process (fpp_no,sp_num,p_Uprice,p_quantity,p_deadline,p_no,p_content) VALUES ('".$_POST["fpp_no"]."','".$_POST["sp_num".$i]."',
								'".$_POST["p_Uprice".$i]."','".$_POST["fp_finished_quantity"]."','".$_POST["p_deadline".$i]."','".$_POST["p_no".$i]."', '".$_POST["p_content".$i]."');";
					execute_sql($link,"company",$sql);
				}
				echo "<script type='text/javascript'>";
				echo "alert('成功新增加工訂單。');";
				echo "document.location.replace('p_content.php?fpp_no=".$_POST["fpp_no"]."');";
				echo "</script>";
			}
		}
	}
	
	$sql = "SELECT rm_order_no, min(rm_quantity) FROM (SELECT rm_order_no, rm_quantity FROM raw_material_order_record WHERE (rm_order_no) NOT IN (SELECT rm_order_no FROM finished_product_process) ORDER BY rm_order_no ASC) as a GROUP BY rm_order_no;";
	$rm = execute_sql($link,"company",$sql);
	while($row = mysqli_fetch_assoc($rm)) {
		$rm_q[$row["rm_order_no"]] = $row["min(rm_quantity)"];
	}
	
	$sql = "SELECT p_no, p_name FROM processor WHERE p_state='營業中' ORDER BY p_no;";
	$p = execute_sql($link,"company",$sql);
	$select_P = "";
	while($row = mysqli_fetch_assoc($p)) {
		$select_P .="<option value='".$row["p_no"]."'>".$row["p_no"]."-".$row["p_name"]."</option>";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>新增加工訂單</title>
    <link href="table.css" rel="stylesheet" type="text/css">
	<style>
		.mytable td *{
			margin: 5px;
		}
		.none tr:hover {
			background-color:transparent;
		}
		.mytable {
			border: 2px solid black;
		}
	</style>
	<script type="text/javascript">
		function plus(e) {
			var target = "";
			if(e.target.id[0]=="U")
				target = "Uvalue_"+e.target.id[1];
			else
				target = "value_"+e.target.id[0];
			var currentVal = parseInt(document.getElementById(target).value);
			document.getElementById(target).value = currentVal + 1;
			input_check(target);
		}
		function minus(e) {
			var target = "";
			if(e.target.id[0]=="U")
				target = "Uvalue_"+e.target.id[1];
			else
				target = "value_"+e.target.id[0];
			var currentVal = parseInt(document.getElementById(target).value);
			if (currentVal-1>0)
				document.getElementById(target).value = currentVal - 1;
			input_check(target);
		}
		function input_check(e) {
			if(typeof(e)=="string")
				var target = e;
			else
				var target = e.target.id;
			var currentVal = document.getElementById(target).value;
			if (!Number(currentVal)) {
				document.getElementById(target).value = 1;
			}
	
			if(target.slice(-1)=="q") {
				if (currentVal>100)
					document.getElementById(target).value = 100;

				var now = parseInt(document.getElementById(target).value);
				
				var target = document.getElementById("subprocess");
				var result = "<tr class='title'><td>加工順序</td><td colspan='2'>加工廠商</td><td>單價</td><td>加工期限</td><td>備註</td></tr>";
				for(i=1;i<=now;i++) {
					result += "<tr><td><input type='hidden' name='sp_num"+i+"' value='"+i+"'>"+i+"</td><td colspan='2'><select name='p_no"+i+"' required><?php echo $select_P;?></select></td><td><button type='button' class='minus' onclick='minus(event)' id='U"+i+"m'>-</button><input type='text' name='p_Uprice"+i+"' value='' style='width:100px;' class='value' id='Uvalue_"+i+"' oninput='input_check(event)' onporpertychange='input_check(event)' required><button type='button' class='plus' onclick='plus(event)' id='U"+i+"p'>+</button></td><td><input type='date' name='p_deadline"+i+"' oninput='date_change(event)' onporpertychange='date_change(event)' required></td><td><input type='text' name='p_content"+i+"' maxlength='6' size='8'></td></tr>";
				}
				target.innerHTML = result;
			}
			else {
				var now = parseInt(document.getElementById("value_q").value);
				
				var target = document.getElementById("price");
				var result = 0;
				var plus = 0;
				for(i=1;i<=now;i++) {
					plus = parseFloat(document.getElementById("Uvalue_"+i).value) * parseInt(document.getElementById("value_o").value);
					if(!Number(plus))
						plus = 0;
					result += plus;
				}
				target.innerHTML = "<input type='hidden' name='p_Tprice' value="+result+" required>"+result;
			}
		}
		function date_change(e) {
			var now = parseInt(document.getElementById("value_q").value);
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
	</script>
	<script type="text/javascript">
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
</head>
<body>
<div id="frame_change"></div>
<form action="<?php echo basename(__FILE__)?>" method="post">
    <div class="fun">		
			<table width="90%" style="margin:0 auto;">
				<tr>
					<td width="60%" style="text-align:center;"><b>新增加工訂單</b></td>
					<td width="10%"><div><a href="process.php">返回</div></td>
					<td>
						<div width="30%" class="new_btn"><button type='submit' name="submit"><img src="pencil.png" heigth="25px" width="25px">確認</button></div>
					</td>
				</tr>
			</table>
		
	</div>
    <table class="mytable none">
        <tr><td width="15%" class="title">物料訂單</td></tr>
            <?php
                $sql = "SELECT rm_order_no,a.s_no,s_name FROM raw_material_order as a,supplier as b WHERE (rm_order_no) NOT IN (SELECT rm_order_no FROM finished_product_process) and a.s_no=b.s_no ORDER BY rm_order_no ASC;";
                $rm_order = execute_sql($link,"company",$sql);
                if (mysqli_num_rows($rm_order)) {
					echo "<tr><td><label><input type='radio' name='rm_order' value='old' checked oninput='radio_change(event)' onporpertychange='radio_change(event)'>選定物料訂單</label><label><input type='radio' name='rm_order' value='new' oninput='radio_change(event)' onporpertychange='radio_change(event)'>新增物料訂單</label></td></tr>\n";
                    
					$select_RON = "物料訂單編號：<select name='rm_order_no' id='no' oninput='opt_change(event)' onporpertychange='opt_change(event)' required>\n";
                    while($row = mysqli_fetch_assoc($rm_order)) {
                        $select_RON.="<option value='".$row["rm_order_no"]."'>".$row["rm_order_no"]."</option>\n";
                    }
					$select_RON = $select_RON."</select>\n";
					$frame = "<iframe name='frame' id='frame' title='frame' width='100%' height='250px' src='rm_order_record.php' frameborder='0px'></iframe>\n";
					
					echo "<tr><td><div id='rm_order_no' style='margin: 10px;'>".$select_RON."</div></td></tr>\n";
					echo "<tr><td><div class='content' id='rm_order_record'>\n".$frame."</div></td></tr>\n";
                }
				else {
					echo "<tr><td><label>新增物料訂單</label><input type='hidden' name='rm_order' value='new'></td></tr>\n";
					echo "<tr><td></div></td></tr>\n";
					echo "<tr><td><table class='mytable' style='margin:10px auto;'>";
					echo_rm_order_form($link);
					echo "</table><table class='mytable' id='raw_material_record' style='margin:10px auto;'>";
					echo_rm_order_record($link);
					echo "</table></td></tr>\n";
				}
            ?>
	</table>
	
	<table class="mytable">
		<tr><td colspan='6'><b>加工製程</b></td></tr>
		<tr class="title" ><td>加工編號</td><td>採購人</td><td>製作成品</td><td>預計完成量</td><td>加工總花費</td><td>委託時間</td></tr>
		<tr>
			<td><input type="text" name="fpp_no" maxlength="8" size="9" required></td>
			<td>
				<?php
					$sql = "SELECT st_no,st_name FROM staff WHERE st_state='就職中' ORDER BY st_no ASC;";
					$staffs = execute_sql($link,"company",$sql);
					if(mysqli_num_rows($staffs)) {
						echo "<select name='st_no' required>\n";
						while($row = mysqli_fetch_assoc($staffs)) {
							echo "<option value='".$row["st_no"]."'>".$row["st_no"]."-".$row["st_name"]."</option>\n";
						}
						echo "</select>";
					}
					else
						echo "<input type='hidden' name='st_no' value=''>無\n";
				?>
			</td>
			<td><?php
					$sql = "SELECT fp_no,fp_name FROM finished_product WHERE fp_state='販售中' ORDER BY fp_no ASC;";
					$fp = execute_sql($link,"company",$sql);
					if(mysqli_num_rows($fp)) {
						echo "<select name='fp_no' required>\n";
						while($row = mysqli_fetch_assoc($fp)) {
							echo "<option value='".$row["fp_no"]."'>".$row["fp_no"]."-".$row["fp_name"]."</option>\n";
						}
						echo "</select>";
					}
					else
						echo "<input type='hidden' name='fp_no' value=''>無\n";
				?>
			</td>
			<td>
				
				<button type="button" class="minus" onclick="minus(event)" id="om">-</button>
				<input type="text" name="fp_finished_quantity" value="" style="width:100px;" class="value" id="value_o" oninput='input_check(event)' onporpertychange='input_check(event)' required>
				<button type="button" class="plus" onclick="plus(event)" id="op">+</button>
			</td>
			<td><div id="price"><input type="hidden" name="p_Tprice" value='' required>0</div></td>
			<td><input type="datetime-local" name="fpp_time" value="<?php date_default_timezone_set("Asia/Taipei"); echo date("Y-m-d\TH:i");?>" required></td>
		</tr>
		<tr>
			<td colspan="2">
				<b>加工程序</b>
				<button type="button" class="minus" onclick="minus(event)" id="qm">-</button>
				<input type="text" name="p_quantity" value="1" class="value" id="value_q" oninput='input_check(event)' onporpertychange='input_check(event)' required>
				<button type="button" class="plus" onclick="plus(event)" id="qp">+</button>
			</td>
		</tr>
	</table>
	<table class="mytable" id="subprocess">
		<tr class="title"><td>加工順序</td><td colspan="2">加工廠商</td><td>單價</td><td>加工期限</td><td>備註</td></tr>
		<tr>
			<td><input type="hidden" name="sp_num1" value="1">1</td>
			<td colspan="2"><select name='p_no1' required>
				<?php echo $select_P;?>
				</select>
			</td>
			<td>
				<button type="button" class="minus" onclick="minus(event)" id="U1m">-</button>
				<input type="text" name="p_Uprice1" value="" style="width:100px;" class="value" id="Uvalue_1" oninput='input_check(event)' onporpertychange='input_check(event)' required>
				<button type="button" class="plus" onclick="plus(event)" id="U1p">+</button>
			</td>
			<td>
				<input type="date" name="p_deadline1" oninput='date_change(event)' onporpertychange='date_change(event)' required>
			</td>
			<td>
				<input type="text" name="p_content1" maxlength="6" size="8">
			</td>
		</tr>
    </table>
</form>
<?php
if(mysqli_num_rows($rm_order)) {
	echo "
	<script type='text/javascript'>
		var rm_q = {'':0,";
	foreach($rm_q as $key => $value) {
		echo '"'.$key.'":"'.$value.'",';
	}
	echo "}
		opt_change();
		function opt_change(e){
			const opt = document.getElementById('no');
			var div = document.getElementById('frame_change');
			
			var opt_v = opt.value;
			
			var form = \"<form action='rm_order_record.php' method='POST' name='form' target='frame'><input type='hidden' name='rm_order_no' value='\"+opt_v+\"'></form>\";
			div.innerHTML = form;
			document.getElementsByName('form')[0].submit();
			
			document.getElementById('value_o').value = rm_q[opt_v];
			input_check('value_o');
		};
		
		function radio_change(e) {
			let target = e.target;
			var rm_order_no = document.getElementById('rm_order_no');
			var rm_order_record = document.getElementById('rm_order_record');
			var price = document.getElementById('price');
			price.innerHTML = \"<input type='hidden' name='p_Tprice' required>0\";
			switch (target.value) {
				case 'old':
					rm_order_no.innerHTML =\"".str_replace("\n","",$select_RON)."\";
					rm_order_record.innerHTML =\"".str_replace("\n","",$frame)."\";
					opt_change();
					break;
				case 'new':
					rm_order_no.innerHTML = '';
					rm_order_record.innerHTML =\"<table class='mytable' style='margin:10px auto;'>";
					echo_rm_order_form($link);
					echo "</table><table class='mytable' id='raw_material_record' style='margin:10px auto;'>";
					echo_rm_order_record($link);
					echo "</table>\";
					document.getElementById('value_o').value='';
					break;
			}
		};
		
		function no_change(e) {
			
		}
	</script>";
}
?>
</body>
</html>

<?php
	mysqli_close($link);
?>