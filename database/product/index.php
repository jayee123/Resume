<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/mainStyle.css">
    <title>產品目錄</title>
	<script type="text/javascript">
	function check(e) {
		var id = e.target.id;
		if (confirm('確定要刪除(設為停賣)編號為'+id+'的成品嗎？') == true) {
			document.getElementById("f"+id).submit();
		}
	}
	</script>
  <style>
    .new_btn {
      width:100px;
      background-color: #ACD6FF;
      padding: 10px;
      margin-left: 20%;
      text-align: center;
    }

    .new_btn a {
      color: white;
      font-weight: bolder;
    }

    .new_btn button {
      color: white;
      font-weight: bolder;
      background-color: #ACD6FF;
      border: none;
    }

    .new_btn button:hover,a:hover {
      color: red;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <header></header>

  <main>
    <?php
      include("mysql.inc.php");

      //查詢功能
      echo '<form action="'.basename(__FILE__).'" method="post">  
			        <table width="90%" style="margin:0 auto;"">
				        <tr>
                  <td width="20%" style="text-align:right;"><b>搜尋：</b></td>
                  <td width="23%" style="text-align:center;">
                    <label><input type="radio" name="opt" value="fp_no" checked>依成品編號</label> 
                    <label><input type="radio" name="opt" value="fp_name">成品名稱</label> 
                    <label><input type="radio" name="opt" value="fp_class">類別</label>
                  </td>
                  <td width="15%" style="text-align:center;" id="query"><input name="query" type="text" required></td>
                  <td width="15%" style="text-align:left;"><input type="submit" name="submit" value="確認"></td> 
                  <td width="10%" style="text-align:left;">';

                  $select = "";
                  if(isset($_POST["submit"]))
                    $select = "WHERE ".$_POST["opt"]." LIKE '%".$_POST['query']."%'";
                    //$select = "WHERE ".$_POST["opt"]."='".$_POST['query']."'";

                  $sql = "SELECT * FROM `finished_product`".$select." ORDER BY `fp_no` ASC";
                  $result = mysqli_query($link, $sql);  

                  if(isset($_POST["submit"]))
                    echo "<a href='".basename(__FILE__)."'>返回</a>";
                  // <div style=\'width: 50px;background-color:yellow;margin: 0 auto;font-size: 25px;\'><a href=addRecord.php>新增</a></div>
                  echo '
                    <td>
                      <div class="new_btn"><a href="addRecord.php"><img src="pencil.png" heigth="25px" width="25px">新增</a></div>
                    </td>
                </tr>
              </table>
            </form>';

      if ( mysqli_num_rows($result) >= 0 )
      {
        echo "<table id='fp' border=0 align='center';>";
        echo "<th>成品編號</th><th>成品名稱</th><th>類別</th><th>成品材質</th><th>庫存數量</th><th>產品狀態</th><th>編輯</th></tr>";
        while ( $row = mysqli_fetch_array($result) ) {

          $style = "";
        if($row["fp_state"]=="停賣")       //當產品狀態為停賣時，修改其整筆資料字體顏色
          $style .= " style = 'color:red;font-weight:700;'";

          $safe = 55;
          $style2 = "";
        if($row["fp_inventory"] < $safe)   //當產品庫存低於安全庫存量時，改變整筆表格的底色
          $style2 = " style = 'background-color:rgb(255,231,178);'";

        //echo $style.'<br>';
        if($row["fp_state"]=="停賣")
          $style2 = "";
        echo '<tr'.$style.'>
            <td>'.$row['fp_no'].'</td>
            <td>'.$row['fp_name'].'</td>
            <td>'.$row['fp_class'].'</td>
            <td>'.$row['fp_made'].'</td>';
            if($row["fp_state"]=="販售中") {
              echo '<td'.$style2.'>'.$row['fp_inventory'].'</td>';
              echo '<td><form action="delAct.php" method="post" id="f'.$row["fp_no"].'" ><button type="button" id="'.$row["fp_no"].'" onclick="check(event)">設定為停賣</button><input type="hidden" name="del" value="'.$row['fp_no'].'" ></form></td>
              <td><a href=editRep.php?edit='.$row['fp_no'].'>編輯</a></td>
            </tr>';
            }
            else {
              echo '<td>X</td>';
              echo '<td colspan="2">停賣</td></tr>'; 
            }
        }
        echo '</table>';
      }
      mysqli_close($link);
    ?>
  </main>
</body>
</html>