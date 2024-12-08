<?php
// 包含MySQL連接文件
    include("mysql.inc.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>原料訂單管理</title>
    <script type="text/javascript">
	// JavaScript函數用於確認刪除操作
	function check(e) {
		var id = e.target.id;
		if (confirm('確定要刪除編號為'+id+'的物料訂單嗎？\n(此項操作可能會影響加工訂單)') == true) {
			document.location.replace('o_delete.php?del='+id);
		}
	}
	// JavaScript函數用於排序表格列
	function sortTable(n) {
		var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
		table = document.getElementsByClassName("mytable")[0];
		switching = true;
		dir = "asc";
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
					switching = true;
				}
			}
		}
	}
	</script>
    <link rel="stylesheet"type="text/css" href="table.css">
</head>
<body>
    <form action="o_index.php" method="post">
		<!-- 用於搜索的表單 -->
    <table width="90%" style="margin:0 auto;">
	<!-- 搜索字段 -->
        <tr>
            <td width="20%" style="text-align:right;"><b>搜尋：</b></td>
			<td width="23%" style="text-align:center;">
                <!--<select name="opt">
                    <option value="no">依訂單編號</option>
                    <option value="time">依訂單時間</option>
                    <option value="supplier">依供應商編號</option>
                </select>-->
				<label><input type="radio" name="opt" value="no" checked>依訂單編號</label> 
				<label><input type="radio" name="opt" value="time">訂單時間</label> 
				<label><input type="radio" name="opt" value="supplier">供應商編號</label>
			</td>
            <td width="15%" style="text-align:center;" id="query"><input type="text" name="search" required></td>
            <td width="15%" style="text-align:left;"><button type="submit" name="submit">搜尋</button></td>
            <td width="10%" style="text-align:left;">
                <?php
                    if (isset($_POST["submit"]))
                        echo "<a href='o_index.php'>返回</a>";
                ?>
            </td>
            <td>
            <div class="new_btn"><a href="new_rm_order.php"><img src="pencil.png" heigth="25px" width="25px">新增</a></div>
            </td>
        </tr>
	</table>
    </form>
    <!-- 用於顯示數據的表格 -->
    <table class='mytable'>
        <!-- 表格標題 -->
            <tr class='title'>
				<!-- 表格標題列 -->
                <td>物料訂單編號</td>
                <td>採購人員</td>
                <td>供應商</td>
                <td>總價</td>
                <td>訂單日期</td>
                <td><a onclick="sortTable(5)">交貨日期 <img src="arrow.png" height="13.5"></a></td>
                <td><a onclick="sortTable(6)">狀態<img src="arrow.png" height="13.5"></a></td>
                <td>刪除</td>
                <td>編輯</td>
                <td>查看更多</td>
            </tr>
			<!-- PHP代碼用於獲取並顯示數據在表格行中 -->
            <?php
			$sql = "";
			if(isset($_POST["submit"]))
				if($_POST["opt"]=="no")
					$sql = " AND rm_order.rm_order_no LIKE '%".$_POST["search"]."%' ";
				else if($_POST["opt"]=="time")
					$sql = " AND rm_order.rm_order_time LIKE '%".$_POST["search"]."%' ";
				else if($_POST["opt"]=="supplier")
					$sql = " AND rm_order.s_no LIKE '%".$_POST["search"]."%' ";
		
            $sql="SELECT rm_order.*, supplier.s_name, staff.st_name
            FROM raw_material_order as rm_order, supplier, staff
            WHERE rm_order.s_no = supplier.s_no".$sql." AND
            rm_order.st_no = staff.st_no
            ORDER BY rm_order.rm_order_time DESC, rm_order.rm_order_no ASC";
            $result=mysqli_query($conn, $sql);

			$state_class = array("待出貨"=>"class='none'","退回"=>"class='ing'","完成"=>"");

            if ( mysqli_num_rows($result) >0 ){

            while ( $row = mysqli_fetch_array($result) ) {
			date_default_timezone_set("Asia/Taipei");
			$now = strtotime("now");
			$seconds = strtotime($row["rm_order_deadline"]) - $now;

			$day = $seconds/86400;
			$day = intval($day);
			
			$warn = "";
			if($day < 2 and $row['rm_order_state']!="完成") {
				$warn = " style='color:red; font-weight:bolder' ";
			}
			
            echo '<tr>
            <td>'.$row['rm_order_no'].'</td>
            <td>'.$row['st_name'].'</td>
            <td>'.$row["s_no"].'-'.$row['s_name'].'</td>
            <td>'.$row['rm_order_Tprice'].'</td>
            <td>'.$row['rm_order_time'].'</td>
            <td'.$warn.'>'.$row['rm_order_deadline'].'</td>
            <td '.$state_class[$row['rm_order_state']].'>'.$row['rm_order_state'].'</td>
            <td><button onclick="check(event)" id="'.$row['rm_order_no'].'">刪除</a></td>
            <td><a href="o_edit.php?edit='.$row['rm_order_no'].'">編輯</a></td>
            <td><a href="o_detail.php?rm_order_no='.$row['rm_order_no'].'">查看更多</a></td>
            </tr>';

            }
			}
            else
				echo "<tr><td colspan='10' style='text-align:center;'>查無資料</td></tr>";

            ?>
         
        
    </table>
</body>
</html>