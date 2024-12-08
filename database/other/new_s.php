<?php 
include_once("dbtools.inc.php");
$link = create_connection();

if(isset($_POST["submit"])) {
		$sql = "SELECT s_no FROM supplier WHERE s_no='".$_POST["s_no"]."';";
		if(mysqli_num_rows(execute_sql($link,"company",$sql))) {
			echo "<script type='text/javascript'>";
			echo "alert('供應商編號重複，請重新輸入。');";
			echo "document.location.replace('".basename(__FILE__)."');";
			echo "</script>";
		}
		else {
			$sql = "INSERT INTO supplier (s_no, s_name, s_address, s_contact, s_phone, s_email) VALUES ('".$_POST["s_no"]."', '".$_POST["s_name"]."', '".$_POST["s_address"]."', '".$_POST["s_contact"]."', '".$_POST["s_phone"]."', '".$_POST["s_email"]."');";
			
			execute_sql($link,"company",$sql);
			echo "<script type='text/javascript'>";
			echo "alert('成功新增供應商。');";
			echo "document.location.replace('supplier.php');";
			echo "</script>";
		}
}

function echo_form($link) {
	mysqli_select_db($link,"company");
	echo "<tr><td class='title' height='100px'>供應商編號</td><td><input type='text' name='s_no' maxlength='8' required></td></tr>";
	echo "<tr><td class='title' height='100px'>名稱</td><td><input type='text' name='s_name' maxlength='20' required size='35'></td></tr>";
	echo "<tr><td class='title' height='100px'>地址</td><td><input type='text' name='s_address' maxlength='40' required size='100'></td></tr>";
	echo "<tr><td class='title' height='100px'>聯絡人</td><td><input type='text' name='s_contact' maxlength='6' required></td></tr>";
	echo "<tr><td class='title' height='100px'>電話</td><td><input type='text' name='s_phone' maxlength='10' required></td></tr>";
	echo "<tr><td class='title' height='100px'>信箱</td><td><input type='email' name='s_email' maxlength='200' required size='50'></td></tr>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>新增供應商</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php echo basename(__FILE__)?>" method="post">
	<div class="fun">		
			<table width="90%" style="margin:0 auto;">
				<tr>
					<td width="60%" style="text-align:center;"><b>新增供應商</b></td>
					<td width="10%"><div><a href="supplier.php">返回</div></td>
					<td>
						<div width="30%" class="new_btn"><button type='submit' name="submit"><img src="pencil.png" heigth="25px" width="25px">確認</button></div>
					</td>
				</tr>
			</table>
		
	</div>
	
	<table class='mytable'>
	<?php
		echo_form($link);
	?>
	</table>
</form>
</body>
</html>

<?php
	mysqli_close($link);
?>