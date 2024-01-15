<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");
//如果以 POST 方式傳遞過來的 inputCid, inputDes 參數都不是空字串
if ( !empty($_POST['no']) &&  !empty($_POST['name']) ){
 //更新所指定編號的記錄
 $sql='UPDATE friend
 SET name = "'.$_POST["name"].'",
 sex = "'.$_POST["sex"].'",
 age = "'.$_POST["age"].'",
 star_signs = "'.$_POST["star_signs"].'",
 height = "'.$_POST["height"].'",
 weight = "'.$_POST["weight"].'",
 career = "'.$_POST["career"].'"
WHERE no = "'.$_POST["no"].'";';
//  echo $sql;
 mysqli_query($conn, $sql);
}
//取得被更新的記錄筆數
$rowUpdated=mysqli_affected_rows($conn);
//如果更新的筆數大於 0, 則顯示成功, 若否, 便顯示失敗
if ($rowUpdated >0){
 echo "資料更新成功";
}
else {

 echo "更新失敗, 或者您輸入的資料與原本相同";
}
?>
<p><a href="Record.php">回系統首頁</a></p>
