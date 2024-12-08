<?php 
include_once("dbtools.inc.php");
$link = create_connection();

if(isset($_POST["submit"])) {
		$sql = "SELECT rm_no FROM raw_material WHERE rm_no='".$_POST["rm_no"]."';";
		if(mysqli_num_rows(execute_sql($link,"company",$sql))) {
			echo "<script type='text/javascript'>";
			echo "alert('物料編號重複，請重新輸入。');";
			echo "document.location.replace('".basename(__FILE__)."');";
			echo "</script>";
		}
		else {
			if($_POST["rm_made"]!="")
				$sql = "INSERT INTO raw_material (rm_no, rm_name, rm_made) VALUES ('".$_POST["rm_no"]."', '".$_POST["rm_name"]."', '".$_POST["rm_made"]."');";
			else
				$sql = "INSERT INTO raw_material (rm_no, rm_name) VALUES ('".$_POST["rm_no"]."', '".$_POST["rm_name"]."');";
			execute_sql($link,"company",$sql);
			echo "<script type='text/javascript'>";
			echo "alert('成功新增物料。');";
			echo "document.location.replace('raw_material.php');";
			echo "</script>";
		}
}

function echo_form($link) {
	mysqli_select_db($link,"company");
	echo "<tr><td class='title' height='100px'>物料編號</td><td><input type='text' name='rm_no' maxlength='6' required></td></tr>";
	echo "<tr><td class='title' height='100px'>名稱</td><td><input type='text' name='rm_name' maxlength='15' required></td></tr>";
	echo "<tr><td class='title' height='100px'>材質</td><td><input type='text' name='rm_made' maxlength='10'></td></tr>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>新增物料</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php echo basename(__FILE__)?>" method="post">
	<div class="fun">		
			<table width="90%" style="margin:0 auto;">
				<tr>
					<td width="60%" style="text-align:center;"><b>新增物料</b></td>
					<td width="10%"><div><a href="raw_material.php">返回</div></td>
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