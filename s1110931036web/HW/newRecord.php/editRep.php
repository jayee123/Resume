<?php
include("mysql.inc.php");
//如果以 GET 方式傳遞過來的 edit 參數不是空字串
if (!empty($_GET['edit'])){
 //查詢 edit 參數所指定編號的記錄, 從資料庫將原有的資料取出
 $sql='SELECT * FROM friend WHERE no = "'.$_GET["edit"].'" ';
//echo $sql;
 $result=mysqli_query($conn, $sql);
//將查詢到的資料(只有一筆)放在 $row 陣列
 $row=mysqli_fetch_array($result);
}
else {
 //如果沒有 edit 參數, 表示此為錯誤執行, 所以轉向回主頁面
 header("Location:Record.php");
}
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
 <!--定義一個編輯資料的表單, 並且將編輯好的資料傳遞給 editAct.php 進行處理 -->
 <form method="post" action="editAct.php">
 類別編號: <?php echo $row['no'];?> <br />
 <input name="no" type="hidden" value="<?php echo $row['no'];?>">

 姓名: <input name="name" value="<?php echo $row['name'];?>"><br />
 性別: <input name="sex" value="<?php echo $row['sex'];?>"><br />
 年齡: <input name="age" value="<?php echo $row['age'];?>"><br />
 星座: <input name="star_signs" value="<?php echo $row['star_signs'];?>"><br />
 身高: <input name="height" value="<?php echo $row['height'];?>"><br />
 體重: <input name="weight" value="<?php echo $row['weight'];?>"><br />
 職業: <input name="career" value="<?php echo $row['career'];?>"><br />

 <input name="submit" type="submit" value="送出">
 </form>
 <p><a href="Record.php">回系統首頁</a></p>
 <footer id="footer">
    <p>資管三甲</p>
    <p>1110931036</p>
    <p>張荃宇</p>
  </footer>
</body>
</html>