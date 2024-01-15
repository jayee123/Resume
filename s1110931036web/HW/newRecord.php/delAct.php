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
<?php
header( 'Content-Type: text/html; charset=utf-8' );
include("mysql.inc.php");
//如果以 GET 方式傳遞過來的 del 參數不是空字串
if ( !empty($_GET["del"]) ){
 //將 del 參數所指定的編號的記錄刪除
 $sql='DELETE FROM friend WHERE no = "'.$_GET["del"].'"';
//  echo $sql;
 mysqli_query($conn, $sql);
//取得被刪除的記錄筆數
 $rowDeleted = mysqli_affected_rows($conn);
 //如果刪除的筆數大於 0, 則顯示成功, 若否, 便顯示失敗
 if ( $rowDeleted >0 ){
 echo "刪除成功";
 }
 else {
 echo "刪除失敗";
 }
}
?>
<p><a href="Record.php">回系統首頁</a></p>

<body>
<footer id="footer">
    <p>資管三甲</p>
    <p>1110931036</p>
    <p>張荃宇</p>
  </footer>
</html>