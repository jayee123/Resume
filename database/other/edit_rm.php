<?php 
include_once("dbtools.inc.php");
$link = create_connection();

if (!isset($_POST["rm_no"]))
	header("Location:raw_material.php");

if(isset($_POST["submit"])) {
		$check = True;
		if($_POST["origin_no"]!=$_POST["rm_no"]) {
			$check = mysqli_num_rows(execute_sql($link,"company","SELECT rm_no FROM raw_material WHERE rm_no='".$_POST["rm_no"]."';"));
			if($check) {
				echo "<script type='text/javascript'>";
				echo "alert('修改之物料編號重複，因此無法編輯，請重新輸入。');";
				echo "</script>";
				$check = False;
				$_POST["rm_no"] = $_POST["origin_no"];
			}
			else
				$check = True;
		}
		if($check) {
			if($_POST["rm_made"]!="")
				$sql = "UPDATE raw_material SET rm_no = '".$_POST["rm_no"]."', rm_name='".$_POST["rm_name"]."', rm_made='".$_POST["rm_made"]."' WHERE rm_no = '".$_POST["origin_no"]."';";
			else
				$sql = "UPDATE raw_material SET rm_no = '".$_POST["rm_no"]."', rm_name='".$_POST["rm_name"]."', rm_made=NULL WHERE rm_no = '".$_POST["origin_no"]."';";
			execute_sql($link,"company",$sql);
			echo "<script type='text/javascript'>";
			echo "alert('成功修改物料資料。');";
			echo "document.location.replace('raw_material.php');";
			echo "</script>";
		}
}

function echo_edit_form($link) {
	mysqli_select_db($link,"company");
	
	$rm = mysqli_fetch_assoc(mysqli_query($link,"SELECT rm_no, rm_name, rm_made FROM raw_material WHERE rm_no = '".$_POST["rm_no"]."';"));
	
	echo "<tr><td class='title' height='100px'>物料編號</td><td><input type='text' name='rm_no' maxlength='6' value='".$rm["rm_no"]."' required>
		  <input type='hidden' name='origin_no' value='".$rm["rm_no"]."'></td></tr>";
	echo "<tr><td class='title' height='100px'>名稱</td><td><input type='text' name='rm_name' maxlength='15' value='".$rm["rm_name"]."' required></td></tr>";
	echo "<tr><td class='title' height='100px'>材質</td><td><input type='text' name='rm_made' maxlength='10' value='".$rm["rm_made"]."'></td></tr>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>編輯物料</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php echo basename(__FILE__)?>" method="post">
	<div class="fun">		
			<table width="90%" style="margin:0 auto;">
				<tr>
					<td width="60%" style="text-align:center;"><b>編輯物料</b></td>
					<td width="10%"><div><a href="raw_material.php">返回</div></td>
					<td>
						<div style="width:25%;" class="new_btn"><button type='submit' name="submit"><img src="pencil.png" heigth="25px" width="25px">編輯確認</button></div>
					</td>
				</tr>
			</table>
		
	</div>
	
	<table class='mytable'>
	<?php
		echo_edit_form($link);
	?>
	</table>
</form>
</body>
</html>

<?php
	mysqli_close($link);
?>