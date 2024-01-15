<?php
	require_once("dbtools.inc.php");
	// 建立資料連接
	$link = create_connection();
	
	//查詢所有欄位, 並且依照編號遞減排序, 讓最新留言顯示在最前面
	$sql="SELECT * FROM guestbook ORDER BY msgId DESC";
	$result = execute_sql($link, "bookcom", $sql);

	$numRows = mysqli_num_rows($result);  //取得留言的總筆數  
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
<?php echo "共有 $numRows 筆留言 "; ?>
 	<div id="navigation"><a href="createMsg.html">我要留言</a></div>
<?php
//如果留言筆數大於 0, 便顯示留言的內容
if ($numRows>0) {
  echo '<ul>';
  $i=1;
  while ($row = mysqli_fetch_array($result)) {
    //將姓名中的特殊字元轉成 HTML 碼
    $name=htmlspecialchars($row['msgName'], ENT_QUOTES);
    //將留言中的特殊字元、換行字元、與空白轉成 HTML 碼
    $message=htmlspecialchars($row['msg'], ENT_QUOTES);
    $message=str_replace('  ', '&nbsp;&nbsp;', nl2br($message));

    //顯示不同的背景顏色, 方便閱讀
    if ($i%2==0) {$liclass='even';}
    else         {$liclass='odd';}

    //顯示留言者姓名、留言日期時間、與留言內容
    echo "<li class=\"$liclass\"><p><strong>$name</strong>
	      <em>於 {$row['msgDate']}留言</em></p>
		  <p>$message</p></li>";
    $i++;
  }
  echo '</ul>';
}
?>
<a href="../index.php">回首頁</a>
</body>
</html>