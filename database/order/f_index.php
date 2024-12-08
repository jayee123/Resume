<?php
    include("mysql.inc.php");// 引入資料庫連線設定
?>

<!DOCTYPE html>
<html>
<head>
    <title>成品訂單管理</title><!-- 設定網頁標題 -->
    <script type="text/javascript">
	function check(e) {// 定義一個用於刪除訂單的函數
		var id = e.target.id;
		if (confirm('確定要刪除編號為'+id+'的成品訂單嗎？') == true) {
			document.location.replace('f_delete.php?del='+id); // 如果確認刪除，則將頁面重定向至刪除處理頁面
		}
	}
	
	function sortTable(n) {// 定義一個用於排序表格的函數
		var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
		table = document.getElementsByClassName("mytable")[0];
		switching = true;
		dir = "asc";// 設定初始排序為升序
		while (switching) {
			switching = false;
			rows = table.rows;
			for (i = 1; i < (rows.length - 1); i++) {
				shouldSwitch = false;
				x = rows[i].getElementsByTagName("TD")[n];
				y = rows[i + 1].getElementsByTagName("TD")[n];
				if (dir == "asc") {
					if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
					  shouldSwitch = true;
					  break;
					}
				}
				else if (dir == "desc") {
					if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
					  shouldSwitch = true;
					  break;
					}
				}
			}
			if (shouldSwitch) {
				rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
				switching = true;
				switchcount ++;
			}
			else {
				if (switchcount == 0 && dir == "asc") {
					dir = "desc";
					switching = true;
				}
			}
		}
		
		while (switching) {
			switching = false;
			rows = table.rows;
			for (i = 1; i < (rows.length - 1); i++) {
				shouldSwitch = false;
				x = rows[i].getElementsByTagName("TD")[0];
				y = rows[i + 1].getElementsByTagName("TD")[0];
				if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
				  shouldSwitch = true;
				  break;
				}
			}
			if (shouldSwitch) {
				rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
				switching = true;
				switchcount ++;
			}
			else {
				if (switchcount == 0 && dir == "asc") {
					dir = "desc";
					switching = true;// 如果第一次排序沒有進行任何切換，改為降序並重試
				}
			}
		}
	}
	</script>
    <link rel="stylesheet"type="text/css" href="table.css"><!-- 引入外部樣式表 -->
</head>
<body>
    
    <form action="f_index.php" method="post"><!-- 定義表單，用於訂單的搜尋 -->
    <table width="90%" style="margin:0 auto;">
        <tr>
            <td width="20%" style="text-align:right;"><b>搜尋：</b></td>
			<td width="23%" style="text-align:center;">
                <!---<select name="opt">
                    <option value="no">依訂單編號</option>
                    <option value="time">依訂單時間</option>
                    <option value="supplier">依供應商編號</option>
                </select>--->
				<label><input type="radio" name="opt" value="no" checked>依訂單編號</label> 
				<label><input type="radio" name="opt" value="time">訂單時間</label> 
				<label><input type="radio" name="opt" value="supplier">供應商編號</label>
			</td>
            <td width="15%" style="text-align:center;" id="query"><input type="text" name="search" required></td><!-- 搜尋輸入框 -->
            <td width="15%" style="text-align:left;"><button type="submit" name="submit">搜尋</button></td><!-- 提交按鈕 -->
            <td width="10%" style="text-align:left;">
                <?php
                    if (isset($_POST["submit"]))
                        echo "<a href='f_index.php'>返回</a>";// 如果有進行搜尋，顯示返回按鈕
                ?>
            </td>
            <td>
            <div class="new_btn"><a href="new_fp_order.php"><img src="pencil.png" heigth="25px" width="25px">新增</a></div> <!-- 新增訂單按鈕 -->
            </td>
        </tr>
	</table>

    </form>
    
    <table class='mytable'><!-- 定義訂單資料表格 -->
        
            <tr class='title'>
                <td>成品訂單編號</td>
                <td>採購人員</td>
                <td>供應商</td>
                <td>總價</td>
                <td>訂單日期</td>
                <td><a onclick="sortTable(5)">交貨日期 <img src="arrow.png" height="13.5"></a></td><!-- 交貨日期排序 -->
                <td><a onclick="sortTable(6)">狀態 <img src="arrow.png" height="13.5"></a></td><!-- 狀態排序 -->
                <td>刪除</td>
                <td>編輯</td>
                <td>查看更多</td>
            </tr>
            <?php
			$sql = "";// 初始化SQL查詢字串
			if(isset($_POST["submit"]))
				if($_POST["opt"]=="no")
					$sql = " AND fp_order.fp_order_no LIKE '%".$_POST["search"]."%' ";// 依訂單編號搜尋
				else if($_POST["opt"]=="time")
					$sql = " AND fp_order.fp_order_time LIKE '%".$_POST["search"]."%' ";// 依訂單時間搜尋
				else if($_POST["opt"]=="supplier")
					$sql = " AND fp_order.s_no LIKE '%".$_POST["search"]."%' ";// 依供應商編號搜尋

            $sql="SELECT fp_order.*, supplier.s_name, staff.st_name
            FROM finished_product_order as fp_order, supplier, staff
            WHERE fp_order.s_no = supplier.s_no ".$sql."AND
            fp_order.st_no = staff.st_no
            ORDER BY fp_order.fp_order_time DESC, fp_order.fp_order_no ASC";// 查詢符合條件的訂單並排序
            $result=mysqli_query($conn, $sql);
			
			$state_class = array("待出貨"=>"class='none'","退回"=>"class='ing'","完成"=>"");// 設定狀態對應的樣式

            if ( mysqli_num_rows($result) >0 ){

                while ( $row = mysqli_fetch_array($result) ) {
					$now = strtotime("now"); 
					// 將當前時間轉換為 Unix 時間戳，`strtotime("now")` 返回的是當前的時間戳。
					// 這行的作用是獲取當前時間的時間戳，方便後續計算時間差。
					
					$seconds = strtotime($row["fp_order_deadline"]) - $now;
					// 將訂單的交貨期限（`fp_order_deadline`）轉換為 Unix 時間戳，然後與當前時間的時間戳進行相減。
					// 這行的作用是計算當前時間與訂單交貨期限之間的秒數差距。
					// 如果結果為正，表示交貨期限在未來；為負，表示交貨期限已過。
				$day = $seconds/86400;
				$day = intval($day);
				
				$warn = "";
				if($day < 2 and $row['fp_order_state']!="完成") {
					$warn = " style='color:red; font-weight:bolder' ";// 如果交貨日期小於2天且狀態未完成，顯示警告樣式
				}

                echo '<tr>
                <td>'.$row['fp_order_no'].'</td>
                <td>'.$row['st_name'].'</td>
                <td>'.$row["s_no"].'-'.$row['s_name'].'</td>
                <td>'.$row['fp_order_Tprice'].'</td>
                <td>'.$row['fp_order_time'].'</td>
                <td'.$warn.'>'.$row['fp_order_deadline'].'</td>
                <td '.$state_class[$row['fp_order_state']].'>'.$row['fp_order_state'].'</td>
                <td><button id="'.$row["fp_order_no"].'" onclick="check(event)">刪除</a></td>
                <td><a href="f_edit.php?edit='.$row['fp_order_no'].'">編輯</a></td>
                <td><a href="f_detail.php?fp_order_no='.$row['fp_order_no'].'">查看更多</a></td>
                </tr>'; // 將每筆訂單資料輸出至表格中

                }
            }
			else
				echo "<tr><td colspan='10' style='text-align:center;'>查無資料</td></tr>"; // 若無符合的資料，顯示查無資料
            ?>
         
        
    </table>
</body>
</html>