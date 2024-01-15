<?php
    include("mysql.inc.php");
    if (!empty( $_POST['name'] ) ){
        $sql="INSERT INTO final_project (name)
         VALUES ('" . $_POST['name']."');";
        // echo $sql;
        mysqli_query($conn, $sql);

    }

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<title>期末報告</title>

<link rel="stylesheet" href="../HW/css/style.css" media="all">
</head>

<body>

<header >
    <a href="../HW/index.php">頁首</a>
    <a href="../Final/index.php">期末報告</a>
    <ul class="menu">
        <li><a href='#'>課堂練習</a>
            <ul>
            <li><a href='../HW/friendList/friendList.php'>我的好友</a></li>
            <li><a href='../HW/newRecord.php/Record.php'>好友維護</a></li>
            <li><a href='../HW/login/login/login.html'>登入</a></li>
            <li><a href='../HW/srcname/srcName.php'>好友查詢</a></li>
            <li><a href='../HW/msgBoard/msgBoard.php'>留言</a></li>
            </ul>
        </li>
    </ul>

</header>
<form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
    <div id="names">
    user姓名: <input name="name">
    <input name="submit" type="submit" value="新增"></br>
    </div>

    <div align="center">
    <input  type="text" name="s1" /></br></br>
    <input  type="text" name="s2" /></br></br>
    <button  type="submit">Submit</button>
    <button  type="reset">Reset</button>
    </div>
</form>
  
<!-- <form method="post" align="center">
    <input type="text" name="s1" /></br></br>
    <input type="text" name="s2" /></br></br>
    <button type="submit">Submit</button>
    <button type="reset">Reset</button>
</form> -->


<?php

$sql= "SELECT * FROM final_project ";
$result=mysqli_query($conn, $sql);


if ( mysqli_num_rows($result) >0 ){
 echo '<table border="1">
 <tr><th>姓名欄位</th></tr>';
 while ( $row = mysqli_fetch_array($result) ) {
 echo '<tr>
 <td>'.$row['name'].'</td>
 </tr>';

 }
 echo '</table></br></br>';
} 
?>



<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $s1 = isset($_POST["s1"]) ? $_POST["s1"] : '';
    $s2 = isset($_POST["s2"]) ? $_POST["s2"] : '';

    function compare1($s1, $s2) {
        $dif = '';

        $len1 = strlen($s1);
        $len2 = strlen($s2);
        $mlen = max($len1, $len2);
        
        echo '1. '.$_POST["s1"].'</br>';
        echo '2. '.$_POST["s2"];

        for ($i = 0; $i < $mlen; ++$i) {
            $c1 = ($i < $len1) ? $s1[$i] : '';
            $c2 = ($i < $len2) ? $s2[$i] : '';

            if ($c1 !== $c2) {
                $count=0;
                if ($count %6==0 && $count!=0) {
                $i=$i+1;
                $dif .= "位置 $i: '$c1' 不同於 '$c2'</br>";
                }
                $i=$i+1;
                echo '<p white-space: pre-wrap>';
                $dif .= "位置 $i: '$c1' 不同於 '$c2'";
                echo '</p>';
            }
        }

        return (empty($dif)) ? '兩字串相同' : $dif;
    }

    $result = compare1($s1, $s2);
    echo '<div id="wrap">' . $result . '</div>';
}

?>










 
  <footer id="footer">
    <p>資管三甲</p>
    <p>1110931036</p>
    <p>張荃宇</p>
  </footer>
</body>
</html>
