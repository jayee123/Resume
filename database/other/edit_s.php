<?php 
include_once("dbtools.inc.php");
$link = create_connection();

if (!isset($_POST["s_no"]))
	header("Location:supplier.php");

if(isset($_POST["submit"])) {
		$check = True;
		if($_POST["origin_no"]!=$_POST["s_no"]) {
			$check = mysqli_num_rows(execute_sql($link,"company","SELECT s_no FROM supplier WHERE s_no='".$_POST["s_no"]."';"));
			if($check) {
				echo "<script type='text/javascript'>";
				echo "alert('修改之供應商編號重複，因此無法編輯，請重新輸入。');";
				echo "</script>";
				$check = False;
				$_POST["s_no"] = $_POST["origin_no"];
			}
			else
				$check = True;
		}
		if($check) {
			$sql = "UPDATE supplier SET s_no = '".$_POST["s_no"]."', s_name='".$_POST["s_name"]."', s_address='".$_POST["s_address"]."', s_contact='".$_POST["s_contact"]."', s_phone='".$_POST["s_phone"]."', s_email='".$_POST["s_email"]."' WHERE s_no = '".$_POST["origin_no"]."';";
			execute_sql($link,"company",$sql);
			echo "<script type='text/javascript'>";
			echo "alert('成功修改供應商資料。');";
			echo "document.location.replace('supplier.php');";
			echo "</script>";
		}
}

function echo_edit_form($link) {
	mysqli_select_db($link,"company");
	
	$rm = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM supplier WHERE s_no = '".$_POST["s_no"]."';"));
	
	echo "<tr><td class='title' height='100px' width='300px'>供應商編號</td><td><input type='text' name='s_no' maxlength='8' value='".$rm["s_no"]."' required>
		  <input type='hidden' name='origin_no' value='".$rm["s_no"]."'></td></tr>";
	echo "<tr><td class='title' height='100px'>名稱</td><td><input type='text' name='s_name' maxlength='20' value='".$rm["s_name"]."' required size='35'></td></tr>";
	echo "<tr><td class='title' height='100px'>地址</td><td><input type='text' name='s_address' maxlength='40' value='".$rm["s_address"]."' required size='100'></td></tr>";
	echo "<tr><td class='title' height='100px'>聯絡人</td><td><input type='text' name='s_contact' maxlength='6' value='".$rm["s_contact"]."' required></td></tr>";
	echo "<tr><td class='title' height='100px'>電話</td><td><input type='text' name='s_phone' maxlength='10' value='".$rm["s_phone"]."' required></td></tr>";
	echo "<tr><td class='title' height='100px'>信箱</td><td><input type='email' name='s_email' maxlength='200' value='".$rm["s_email"]."' required size='50'></td></tr>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>編輯供應商</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php echo basename(__FILE__)?>" method="post">
	<div class="fun">		
			<table width="90%" style="margin:0 auto;">
				<tr>
					<td width="60%" style="text-align:center;"><b>編輯供應商</b></td>
					<td width="10%"><div><a href="supplier.php">返回</div></td>
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