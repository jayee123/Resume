<?php
    include("mysql.inc.php");

    if (isset($_GET['edit'])){
      //查詢 edit 參數所指定編號的記錄, 從資料庫將原有的資料取出
      $sql='SELECT * FROM finished_product WHERE fp_no = "'.$_GET["edit"].'" ';
      //echo $sql;
      $result=mysqli_query($conn, $sql);
      //將查詢到的資料(只有一筆)放在 $row 陣列
      $row=mysqli_fetch_array($result);
      if(!isset($row))
        header("Location:index.php");
    }
    else {
      //如果沒有 edit 參數, 表示此為錯誤執行, 所以轉向回主頁面
      header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html>  
<head>
    <meta charset="UTF-8">
    <title>Edit</title>
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
  <!--定義一個編輯資料的表單, 並且將編輯好的資料傳遞給 editAct.php 進行處理 -->
  <div style="width:500px;margin: 160px auto; text-align:center;">
    <form method="post" action="editAct.php">
	<table class="mytable" style="border:none;">
    <tr><td class="title">成品編號</td><td><?php echo $row['fp_no'];?><input name="fp_no" type="hidden" value="<?php echo $row['fp_no'];?>"></td></tr>
    <tr><td class="title">成品名稱</td><td><input name="fp_name" value="<?php echo $row['fp_name'];?>" maxlength="15" required></td></tr>
    <tr><td class="title">類別</td><td><input name="fp_class" value="<?php echo $row['fp_class'];?>" maxlength="6" required></td></tr>
    <tr><td class="title">成品材質</td><td><input name="fp_made" value="<?php echo $row['fp_made'];?>" maxlength="10"></td></tr>
    <tr><td class="title">庫存數量</td><td><button type="button" class="minus" onclick="minus(event)" id="m">-</button>
				<input type="text" name="fp_inventory" value="<?php echo $row['fp_inventory'];?>" style="width:100px;" class="value" id="fp_inventory" oninput='input_check(event)' onporpertychange='input_check(event)' required>
				<button type="button" class="plus" onclick="plus(event)" id="p">+</button></td></tr>
    <tr><td colspan="2"><input name="submit" type="submit" value="送出"></td></tr></table>
    </form>
    <p><a href="index.php">回首頁</a></p>
  </div>
</body>
</html>