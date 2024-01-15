<?php
	require_once("dbtools.inc.php");
	// 建立資料連接
	$link = create_connection();
	
	$errMsg='';            // 存放錯誤訊息的變數
	$name ='';             // 存放留言者姓名的變數 
	$message ='';          // 存放留言內容的變數

	//檢查是否已輸入姓名和留言 
	if ( !empty($_POST['name']) && !empty($_POST['message'])) {
	  //將姓名放入 $name 變數
	  $name = $_POST['name'];
	  //將留言放入 $message 變數
	  $message = $_POST['message'];
	}
	//若否, 則將錯誤訊息寫入 $errMsg 變數
	else {
	  $errMsg.='您忘記輸入姓名<br>';
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>簡易留言板</title>
  <link href="./css/msgBrd.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="wrapper">
  <div id="title">
    <h1>簡易留言板</h1>
  </div>
  <div id="maintext">
<?php
//如果 $errMsg 是空字串, 表示沒有錯誤,
//所以我們可以放心將留言寫入資料庫
if ($errMsg ==''){
	date_default_timezone_set('Asia/Taipei');     //設定時區
	$now = date("Y-m-d H:i:s");
  
	$sql = "INSERT INTO guestbook (`msgName`, `msg`, `msgDate`)
			VALUES ('$name','$message','$now')";

	$result = execute_sql($link, "bookcom", $sql);
  
	if ($result){
		echo '已成功新增一筆留言<br>';
	}
	else {
		echo '無法新增留言<br>';
	}
}
//如果 $errMsg 不是空字串, 便顯示錯誤訊息
else {
  echo $errMsg . '請按瀏覽器的上一頁鈕重新輸入<br>';
}
?>
    <p><a href="msgBoard.php">回留言板</a></p>
  </div>
</body>
</html>