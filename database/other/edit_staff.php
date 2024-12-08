<?php 
include_once("dbtools.inc.php");
$link = create_connection();

if (!isset($_POST["st_no"]))
	header("Location:staff.php");

if(isset($_POST["submit"])) {
		$check = True;
		if($_POST["origin_no"]!=$_POST["st_no"]) {
			$check = mysqli_num_rows(execute_sql($link,"company","SELECT st_no FROM staff WHERE st_no='".$_POST["st_no"]."';"));
			if($check) {
				echo "<script type='text/javascript'>";
				echo "alert('修改之員工編號重複，因此無法編輯，請重新輸入。');";
				echo "</script>";
				$check = False;
				$_POST["st_no"] = $_POST["origin_no"];
			}
			else
				$check = True;
		}
		if($check) {
			$sql = "UPDATE staff SET st_no = '".$_POST["st_no"]."', st_name='".$_POST["st_name"]."' WHERE st_no = '".$_POST["origin_no"]."';";
			execute_sql($link,"company",$sql);
			echo "<script type='text/javascript'>";
			echo "alert('成功修改採購人資料。');";
			echo "document.location.replace('staff.php');";
			echo "</script>";
		}
}

function echo_edit_form($link) {
	mysqli_select_db($link,"company");
	
	$staff = mysqli_fetch_assoc(mysqli_query($link,"SELECT st_no, st_name FROM staff WHERE st_no = '".$_POST["st_no"]."';"));
	
	echo "<tr><td class='title' height='100px'>採購人編號</td><td><input type='text' name='st_no' maxlength='5' value='".$staff["st_no"]."' required>
		  <input type='hidden' name='origin_no' value='".$staff["st_no"]."'></td></tr>";
	echo "<tr><td class='title' height='100px'>姓名</td><td><input type='text' name='st_name' maxlength='6' value='".$staff["st_name"]."' required></td></tr>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>編輯採購人</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php echo basename(__FILE__)?>" method="post">
	<div class="fun">		
			<table width="90%" style="margin:0 auto;">
				<tr>
					<td width="60%" style="text-align:center;"><b>編輯採購人</b></td>
					<td width="10%"><div><a href="staff.php">返回</div></td>
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