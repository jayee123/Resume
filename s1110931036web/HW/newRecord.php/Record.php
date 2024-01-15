 <?php
    include("mysql.inc.php");
    if (!empty( $_POST['no'] )&& !empty( $_POST['name'] ) ){
        $sql="INSERT INTO friend (no, name, sex, age, star_signs, height, weight, career)
         VALUES ('" . $_POST['no']."', '".
        $_POST['name']."', '". $_POST['sex']."', '". 
        $_POST['age']."', '". $_POST['star_signs']."', '". 
        $_POST['height']."', '". $_POST['weight']."', '". 
        $_POST['career']."');";
        // echo $sql;
        mysqli_query($conn, $sql);

    }

?> 
 <?php
    include("mysql.inc.php");
    if (!empty( $_POST['no'] )&& !empty( $_POST['name'] ) ){
        $sql="INSERT INTO friend (no, name, sex, age, star_signs, height, weight, career)
         VALUES ('" . $_POST['no']."', '".
        $_POST['name']."', '". $_POST['sex']."', '". 
        $_POST['age']."', '". $_POST['star_signs']."', '". 
        $_POST['height']."', '". $_POST['weight']."', '". 
        $_POST['career']."');";
        // echo $sql;
        mysqli_query($conn, $sql);

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
<form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
編號: <input name="no">
姓名: <input name="name">
性別: <input name="sex">
年齡: <input name="age">
星座: <input name="star_signs">
身高: <input name="height">
體重: <input name="weight">
職業: <input name="career">





 <input name="submit" type="submit" value="新增">
 </form>
 <?php

$sql= "SELECT * FROM friend ORDER BY no";
$result=mysqli_query($conn, $sql);


if ( mysqli_num_rows($result) >0 ){
 echo '<hr><table border="1">
 <tr><th>編號欄位</th><th>姓名欄位</th><th>性別欄位</th>
 <th>年齡欄位</th><th>星座欄位</th><th>身高欄位</th><th>體重欄位</th>
 <th>職業欄位</th><th scope="col" colspan = 2>操作</th></tr>';
 while ( $row = mysqli_fetch_array($result) ) {
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