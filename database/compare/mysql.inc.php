<?php
//資料庫設定
$dbServer = "localhost";  // MySQL主機名稱
$dbUser = "root";         // 使用者名稱
$dbPass = "";              // 密碼
$dbName = "company";     // 預設使用的資料庫名稱 

//連線資料庫伺服器
$conn = @mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);

if (!$conn)
  die("無法連線資料庫伺服器");

//設定連線的字元集為 UTF8 編碼
mysqli_set_charset($conn, "utf8");
?>
