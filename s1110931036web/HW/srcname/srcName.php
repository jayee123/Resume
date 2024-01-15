<?php
  require_once("dbtools.inc.php");
    // 建立資料連接
  $link = create_connection();
//預設網頁開啟時的查詢
  $sql="SELECT * FROM friend ORDER BY no ASC";
  
//若是按下 "搜尋" 
  if(isset($_POST["actSrh"])){
	$strSrh = ""; //暫存SQL語法中的WHERE子句
	$nowname="";  //暫存目前要查詢的書名
	$nowcareer="";  //暫存目前要查詢的類別
	
	//判斷使用者的查詢條件，並產生對應的SQL語法
	if (!empty($_POST['nameSrh']) && !empty($_POST['typeSrh'])){
		$nowname=$_POST['nameSrh'];
		$nowcareer=$_POST['typeSrh'];
		$strSrh = "WHERE name Like '%".$nowname."%' AND star_signs = '".$nowcareer."'";/** */
	}
	else if (!empty($_POST['nameSrh']) && empty($_POST['typeSrh'])){
		$nowname=$_POST['nameSrh'];
		$strSrh = "WHERE name Like '%".$nowname."%'";/** */
	}
	else if (empty($_POST['nameSrh']) && !empty($_POST['typeSrh'])){
		$nowcareer=$_POST['typeSrh'];
		$strSrh = "WHERE star_signs = '".$nowcareer."'";/** */
	}
	else{}

	$sql="SELECT * FROM friend ".$strSrh." ORDER BY no ASC";
	// echo  "</br>".$sql;/** */
    }
 
  //查詢: 如果是第一次載入, 則會執行預設的$sql, 若是按下 [搜尋]鈕, 則執行組合後的$sql
  $result = execute_sql($link, "friend_club", $sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<title>期末報告</title>

<link rel="stylesheet" href="../css/style.css" media="all">
</head>

<body>

<header >
    <a href="../index.php">頁首</a>
    <a href="../../Final/index.php">期末報告</a>
    <ul class="menu">
        <li><a href='#'>課堂練習</a>
            <ul>
            <li><a href='../friendList/friendList.php'>我的好友</a></li>
            <li><a href='../newRecord.php/Record.php'>好友維護</a></li>
            <li><a href='../login/login/login.html'>登入</a></li>
            <li><a href='../srcname/srcName.php'>好友查詢</a></li>
            <li><a href='../msgBoard/msgBoard.php'>留言</a></li>
            </ul>
        </li>
    </ul>

</header>

<!-- <!—自資料庫取得下拉式選單的值  -->
<?php
	//自資料庫取得 “type” Distinct的值
    $sql_type = "SELECT DISTINCT star_signs FROM friend ORDER BY star_signs";/** */	
    $typeResult = execute_sql($link, "friend_club", $sql_type);

	//這是是測試用, 顯示數量的筆數
    $list_no = mysqli_num_rows($typeResult);
	echo "<br>筆數: ".$list_no."</br>";
	echo "<hr/>";
?>

<!-- 表單 -->
  <form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
	<table border="0">
	  <tr>
	    <td>人名:<input name="nameSrh"></td>

	    <td>類別:<select name="typeSrh">  
		    <?php   
			   echo "<option value='' selected>請選擇</option>\n";
                //使用迴圈將查詢結果加入清單中
                //當$typeV不是空值時, 迴圈繼續
                while($typeV = mysqli_fetch_assoc($typeResult)){	
			      $strType = $typeV['star_signs'];/** */
			       echo "<option value=".$strType." >$strType</option>\n";
			   }
		    ?>
		</td>

		<td>
		  <input name="actSrh" type="submit" value="搜尋">
		</td>
	  </tr>
	</table>
  </form>  
<?php

//如果 $result查到的記錄筆數大於 0, 便使用迴圈顯示所有資料
if (mysqli_num_rows($result) >0){
    echo "<hr /><table border='1'>
          <tr><td>編號</td><td>姓名</td><td>性別</td>
		      <td>年齡</td><td>星座</td><td>身高</td><td>體重</td><td>職業</td><td colspan='2'>動作</td></tr>";

    while ($row = mysqli_fetch_array($result)) {
      echo '<tr>
			<td>'.$row['no'].'</td>
			<td>'.$row['name'].'</td>
			<td>'.$row['sex'].'</td>	
			<td>'.$row['age'].'</td>
			<td>'.$row['star_signs'].'</td>
			<td>'.$row['height'].'</td>
			<td>'.$row['weight'].'</td>
			<td>'.$row['career'].'</td>
			<td><a href=delAct.php?del='.$row['no'].'>刪除</a></td>
			<td><a href=editRep.php?edit='.$row['no'].'>編輯</a></td>
			</tr>';
			//目前刪除和編輯的網頁未完成, 所以無法使用
  }
  echo '</table>';
  
}
?>
  <footer id="footer">
    <p>資管三甲</p>
    <p>1110931036</p>
    <p>張荃宇</p>
  </footer>
</body>
</html>
