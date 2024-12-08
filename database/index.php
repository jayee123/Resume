<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>興富康系統</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
	<!-- 標題部分 -->
    <div class="title">
		<!-- 主標題 -->
        <h1 id="title">興富康工業有限公司系統－物料訂單</h1>
    </div>
	<!-- 顯示當前時間的區塊，由PHP和JavaScript動態更新 -->
    <div id="time">
		<?php 
		// 設置時區並顯示當前時間
		date_default_timezone_set("Asia/Taipei"); echo date("Y/m/d H:i:s");
		?>
	</div>
	 <!-- JavaScript代碼部分 -->
	<script  type="text/javascript">
		let date = document.querySelector("#time");
		// 定義更新時間的函數，並每秒執行一次
		function updateDate() {
			let newDate = new Date();
			let year = (newDate.getFullYear()).toString();
			let month = (newDate.getMonth() + 1).toString().padStart(2,"0");
			let days = (newDate.getDate()).toString().padStart(2,"0");
			let hour = (newDate.getHours()).toString().padStart(2,"0");
			let mins = (newDate.getMinutes()).toString().padStart(2,"0");
			let sec = (newDate.getSeconds()).toString().padStart(2,"0");
			let clockJSRead = year+"/"+month+"/"+days+" "+hour+":"+mins+":"+sec;
			// 更新顯示時間
			date.textContent = clockJSRead;
		}
		setInterval(updateDate, 1000);
		// 根據選擇的菜單項目更改頁面標題
		function change_title(e) {
			let id;
			if(typeof(e)=="string")
				id = e;
			else
				id = e.target.id;
			let title = document.getElementById("title");
			// 根據選中的選項，變更標題內容
			if (id=="rm_order")
				title.innerHTML = "興富康工業有限公司系統－物料訂單";
			else if (id=="fp_order")
				title.innerHTML = "興富康工業有限公司系統－成品訂單";
			else if (id=="fpp")
				title.innerHTML = "興富康工業有限公司系統－加工訂單";
			else if (id=="compare")
				title.innerHTML = "興富康工業有限公司系統－訂單比價";
			else if (id=="fp")
				title.innerHTML = "興富康工業有限公司系統－產品目錄";
			else if (id=="supplier")
				title.innerHTML = "興富康工業有限公司系統－供應商";
			else if (id=="processor")
				title.innerHTML = "興富康工業有限公司系統－加工商";
			else if (id=="rm")
				title.innerHTML = "興富康工業有限公司系統－物料";
			else if (id=="staff")
				title.innerHTML = "興富康工業有限公司系統－採購人";
		}
	</script>
	<!-- 菜單部分 -->
	<div class="menu">
        <table style="width:70%;"><tr>
        <td>
			<!-- 訂單子菜單 -->
			<div class="btn" id="other">訂單
				<div class="box">
					<div class="btn content">
						<!-- 物料訂單鏈接 -->
						<a href="./order/o_index.php" id="rm_order" onclick="change_title(event)" target="main_frame">物料訂單</a></div>
					<div class="btn content">
						<!-- 成品訂單鏈接 -->
						<a href="./order/f_index.php" id="fp_order" onclick="change_title(event)" target="main_frame">成品訂單</a></div>
				</div>
			</div>
		</td>
		<!-- 各個功能頁面的鏈接 -->
        <td><div class="btn"><a href="./process/process.php" id="fpp" onclick="change_title(event)" target="main_frame">加工訂單</div></a></td>
		<td><div class="btn"><a href="./compare/compare.php" id="compare" onclick="change_title(event)" target="main_frame">訂單比價</a></div></td>
        <td><div class="btn"><a href="./product/index.php" id="fp" onclick="change_title(event)" target="main_frame">產品目錄</a></div></td>
        <td>
			<!-- 其他資料子菜單 -->
			<div class="btn" id="other">其他資料
				<div class="box">
					<div class="btn content">
						 <!-- 供應商鏈接 -->
						<a href="./other/supplier.php" id="supplier" onclick="change_title(event)" target="main_frame">供應商</a></div>
					<div class="btn content">
						<!-- 加工商鏈接 -->
						<a href="./other/processor.php" id="processor" onclick="change_title(event)" target="main_frame">加工商</a></div>
					<div class="btn content">
						<!-- 物料鏈接 -->
						<a href="./other/raw_material.php" id="rm" onclick="change_title(event)" target="main_frame">物料</a></div>
					<div class="btn content">
						<!-- 採購人鏈接 -->
						<a href="./other/staff.php" id="staff" onclick="change_title(event)" target="main_frame">採購人</a></div>
				</div>
			</div>
		</td>
        </tr></table>
    </div>
    <br>
	 <!-- 主要內容顯示區域，使用iframe嵌入其他頁面 -->
    <div class="content">
        <iframe
		id="frame"
		name="main_frame"
		title="frame"
		width="100%"
		height="650px"
		src="order/o_index.php"
		frameborder="0px">
        </iframe>
    </div>
</body>
</html>