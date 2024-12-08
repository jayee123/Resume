<?php
  include("mysql.inc.php");

  if(isset($_POST["submit"])){
	if(mysqli_num_rows(mysqli_query($conn,"SELECT fp_no FROM finished_product WHERE fp_no = '".$_POST["fp_no"]."'"))) {
		//成品編號重複，不新增資料
		echo "<script type='text/javascript'>";
		echo "alert('成品編號重複，請重新輸入。');";
		echo "document.location.replace('".basename(__FILE__)."');";
		echo "</script>";
	}
	else {
		//若材質未填入，則新增資料為Null
		if($_POST["fp_made"]!="")
			$fp_made = "'".$_POST["fp_made"]."'";
		else
			$fp_made = "NULL";
		
		$sql="INSERT INTO finished_product (fp_no, fp_name, fp_class, fp_made, fp_inventory) VALUES ('" . $_POST['fp_no']."', '". $_POST['fp_name']."', '". $_POST['fp_class']."', ". $fp_made.", '". $_POST['fp_inventory']."');";
		//echo $sql;
		
		//新增成功訊息
		mysqli_query($conn, $sql);
		echo "<script type='text/javascript'>";
		echo "alert('成功新增編號為".$_POST["fp_no"]."的成品。');";
		echo "document.location.replace('index.php');";
		echo "</script>";
	}
  }
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>add</title>
 <script type="text/javascript">
	function plus(e) {
			var target = "fp_inventory";
			var currentVal = parseInt(document.getElementById(target).value);
			document.getElementById(target).value = currentVal + 1;
			input_check(target);
		}
		function minus(e) {
			var target = "fp_inventory";
			var currentVal = parseInt(document.getElementById(target).value);
			if (currentVal>0)
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
				document.getElementById(target).value = 0;
			}
		}
	</script>
	<style>
	.value {
	  width: 50px;
	  text-align: center;
	  border: 0;
	  border-top: 1px solid #aaa;
	  border-bottom: 1px solid #aaa;
	}


	input.plus {
	  width: 25px;
	  border: 1px solid #aaa;
	  background: #f8f8f8;
	}

	input.minus {
	  width: 25px;
	  border: 1px solid #aaa;
	  background: #f8f8f8;
	}
	</style>
	<link rel="stylesheet" type="text/css" href="css/table.css">
</head>
<body>
  <div style="width:500px;margin: 160px auto 0; text-align: center;">
    <form method="post" action="<?php echo basename(__FILE__); ?>">
	<table class="mytable" style="border: none;">
    <tr><td class="title">成品編號</td><td><input name="fp_no" maxlength="6" required></td></tr>
    <tr><td class="title">成品名稱</td><td><input name="fp_name" maxlength="15" required></td></tr>
    <tr><td class="title">類別</td><td><input name="fp_class" maxlength="6" required></td></tr>
    <tr><td class="title">成品材質</td><td><input name="fp_made" maxlength="10"></td></tr>
    <tr><td class="title">庫存數量</td><td><button type="button" class="minus" onclick="minus(event)" id="m">-</button>
				<input type="text" name="fp_inventory" value="0" style="width:100px;" class="value" id="fp_inventory" oninput='input_check(event)' onporpertychange='input_check(event)' required>
				<button type="button" class="plus" onclick="plus(event)" id="p">+</button></td></tr>
    <tr><td colspan="2"><input name="submit" type="submit" value="送出"></td></tr>
	</table>
    </form>
    <p><a href="index.php">回首頁</a></p>
  </div>
</body>
</html>