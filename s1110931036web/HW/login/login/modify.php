<?php
  // 檢查 cookie 中的 passed 變數是否等於 TRUE 
  $passed = $_COOKIE["passed"];
	
  // 如果 cookie 中的 passed 變數不等於 TRUE
  // 表示尚未登入網站，將使用者導向首頁 index.html
  if ($passed != "TRUE")
  {
    header("location:login.html");
    exit();
  }
	
  // 如果 cookie 中的 passed 變數等於 TRUE
  // 表示已經登入網站，取得使用者資料	
  else
  {
    require_once("dbtools.inc.php");
		
    $id = $_COOKIE["no"];
		
    // 建立資料連接
    $link = create_connection();
				
    // 執行 SELECT 陳述式取得使用者資料
    $sql = "SELECT * FROM friend Where no = $id";
    $result = execute_sql($link, "friend_club", $sql);/** */
		
    $row = mysqli_fetch_assoc($result);  
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<title>期末報告</title>

<link rel="stylesheet" href="../../css/style.css" media="all">
</head>

<body>

<header >
    <a href="../../index.php">頁首</a>
    <a href="../../../Final/index.php">期末報告</a>
    <ul class="menu">
        <li><a href='#'>課堂練習</a>
            <ul>
            <li><a href='../../friendList/friendList.php'>我的好友</a></li>
            <li><a href='../../newRecord.php/Record.php'>好友維護</a></li>
            <li><a href='login.html'>登入</a></li>
            <li><a href='../../srcname/srcName.php'>好友查詢</a></li>
            <li><a href='../../msgBoard/msgBoard.php'>留言</a></li>
            </ul>
        </li>
    </ul>

</header>
    <h1 align="center">修改會員資料</h1>
    <form name="myForm" method="post" action="update.php" >
      <table border="2" align="center" bordercolor="#789eff">
        <tr> 
          <td colspan="2" bgcolor="#789eff" align="center"> 
            <font color="#FFFFFF">請填入下列資料 (標示「*」欄位請務必填寫)</font>
          </td>
        </tr>
        <tr bgcolor="#8cffb7"> 
          <td align="right">*使用者帳號：</td>
          <td><?php echo $row["name"] ?></td>
        </tr>
        <tr bgcolor="#8cffb7"> 
          <td align="right">*使用者密碼：</td>
          <td> 
            <input type="password" name="no" size="15" value="<?php echo $row["no"] ?>">
            (請使用英文或數字鍵，勿使用特殊字元)
          </td>
        </tr>
        <tr bgcolor="#8cffb7"> 
          <td align="right">*密碼確認：</td>
          <td>
            <input type="password" name="no" size="15" value="<?php echo $row["no"] ?>">
            (再輸入一次密碼，並記下您的使用者名稱與密碼)
          </td>
        </tr>
        <tr bgcolor="#8cffb7"> 
          <td align="right">*姓名：</td>
          <td><input type="text" name="name" size="8" value="<?php echo $row["name"] ?>"></td>
        </tr>
        <tr bgcolor="#8cffb7"> 
          <td align="right">*性別：</td>
          <td> 
          <input type="text" name="sex" size="8" value="<?php echo $row["sex"] ?>">
          </td>
        </tr>
        <tr bgcolor="#8cffb7"> 
          <td align="right">*年齡：</td>
          <td> 
            <input type="text" name="age" size="8" value="<?php echo $row["age"] ?>">
          </td>
        </tr>
        <tr bgcolor="#8cffb7"> 
          <td align="right">星座：</td>
          <td> 
            <input type="text" name="star_signs" size="20" value="<?php echo $row["star_signs"] ?>">
          </td>
        </tr>
        <tr bgcolor="#8cffb7"> 
          <td align="right">身高</td>
          <td> 
            <input type="text" name="height" size="20" value="<?php echo $row["height"] ?>">
        
          </td>
        </tr>
        <tr bgcolor="#8cffb7"> 
          <td align="right">體重：</td>
          <td><input type="text" name="weight" size="45" value="<?php echo $row["weight"] ?>"></td>
        </tr>
        <tr bgcolor="#8cffb7"> 
          <td align="right">職業：</td>
          <td><input type="text" name="career" size="30" value="<?php echo $row["career"] ?>"></td>
        </tr>
        
        <tr bgcolor="#8cffb7"> 
          <td colspan="2" align="CENTER"> 
            <input type="submit" value="修改資料">
            <input type="reset" value="重新填寫">
          </td>
        </tr>
      </table>
    </form>
    <footer id="footer">
    <p>資管三甲</p>
    <p>1110931036</p>
    <p>張荃宇</p>
  </footer>
  </body>
</html>
<?php
    // 釋放資源及關閉資料連接
    mysqli_free_result($result);
    mysqli_close($link);
  }
?>