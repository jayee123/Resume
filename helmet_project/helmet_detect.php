<?php
	if (isset($_POST["id"])) {
		$file_name = $_POST["file_name"];
		$id = $_POST["id"];
		$mode = $_POST["mode"];
	}
	else
		header("Location: upload.html");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>機車安全帽辨識</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="spinner.css">
	<script src="jquery-3.5.1.min.js"></script>
	<style>
		body {
			font-family: Arial, sans-serif;
			display: flex;
			/* justify-content: center; */
			align-items: center;
			/* height: 100vh; */
			margin: 0;
			background-color: #f0f0f0;
		}

		.container {
			display: block;
			background-color: #ffffff;
			padding: 10px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			width: 80%;
			max-width: 1200px;
			margin: 0px;
			margin-bottom: 20px;
		}

		.header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-top: 10px;
			margin-bottom: 10px;
			margin-left: auto;
			margin-right: 10%;
		}

		.header h1 {
			font-size: 24px;
			color: #1a1a1a;
		}

		.buttons button {
			background-color: #007bff;
			color: white;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			margin-left: 10px;
			cursor: pointer;
		}

		.buttons button:hover {
			background-color: #0056b3;
		}

		.content > p {
			margin: 25px 0;
			font-size: 20px;
			text-align: center;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}

		table, th, td {
			border: 1px solid #ccc;
			text-align: center;
			padding: 15px;
		}

		td {
			font-size: 18px;
		}

		td:nth-child(even) {
			background-color: #f9f9f9;
		}
		
		#download, #output {
			text-align: center;
		}
		
		#download {
			margin-bottom: 10px;
		}
		
		#download button {
			background-color: #548C00;
		}
		
		#download button:hover {
			background-color: #467500;
		}
		
		#page {
			text-align: center;
			margin: 10px 0;
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
		}
		
		input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
		
		.arrow {
			height: 25px;
			width: 25px;
			background: url("./arrow.png");
			background-size: cover;
			background-repeat: no-repeat;
			margin: 10px;
			border-radius: 5px;
		}
		
		.arrow:hover {
			cursor: pointer;
		}
		
		.right {
			transform: rotate(180deg);
		}
		
		#images {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
		}
		
		.frame {
			margin: 10px;
			padding: 0;
			max-width: 30%;
			text-align: center;
		}
		
		.frame img {
			width: 100%;
			height: auto;
			display: block;
		}
		
		.frame p {
			text-align: center;
			padding: 0;
			margin: 1px;
		}
	</style>
</head>
<body>
	<div class="header">
		<div class="buttons">
			<button id="return">返回</button>
		</div>
	</div>
	<h1>機車安全帽辨識</h1>
<div class="container">
	<div class="content">
		<div class="spinner" style="margin: 10px auto; width:150px; height:150px;">
			<div class="word" id="progress" style="font-size: 20px;"></div>
			<div class="spinnerBlue spinnerSector" id="blueSector"></div>
		</div>
		<p><?php echo $file_name;?> 辨識結果</p>
		<div>
			<div id="download"></div>
			<div id="output"></div>
		</div>
		<div id="page"></div>
		<div id="images"></div>
	</div>
</div>
<div class="background" id="enlarge" style="display: none; background-color: rgba(255, 255, 255, 0.5)">
</div>
<script>
	$(document).ready( function() {
		$("#return").on("click", function() {window.location.replace("./upload.html");})
		const $progress = $("#progress");
		const $spinnerSector = $("#blueSector");
		const id = "<?php echo $id;?>";
		const mode = "<?php echo $mode;?>";
		let now = -1;
		
		let images = [];
		let frame_times = [];
		let page = 1;
		let total_page = 1;
		let frame_path = "";
		const frames_per_page = 51;
		
		if (mode == "video") {
			$left_arrow = $("<div class='arrow'></div>");
			$("#page").append($left_arrow);
			
			const $input = $("<input type='number' value='1' min='1' max='3' id='page_num' style='text-align: center;'>")
			$("#page").append($input);
			
			$right_arrow = $("<div class='arrow right'></div>");
			$("#page").append($right_arrow);
			
			$input.on("input", function() {
				if (this.value > total_page)
					this.value = total_page;
				if (this.value < 1)
					this.value = 1;
				$input.change();
			});

			$input.on("change", function() {
				if (page != this.value) {
					page = this.value;
					
					$("#images").html("");
					for (let i = ((page - 1) * frames_per_page); i < (page * frames_per_page); i++) {
						if (i >= images.length)
							break;
						
						const frame_num = images[i][0];
						const license_plates = images[i].slice(1);
						
						add_frame(frame_num, license_plates[0]);
						for (let j = 1; j < license_plates.length; j++) {
							$(`#LP_${frame_num}`).append(" / "+license_plates[j]);
						}
						if (frame_times[i] != null) {
							add_time(frame_num, frame_times[i]);
						}
					}
				}
			});
			
			$left_arrow.on("click", function() {
				$input[0].value = parseInt($input[0].value) - 1;
				$input.trigger("input");
			});
			
			$right_arrow.on("click", function() {
				$input[0].value = parseInt($input[0].value) + 1;
				$input.trigger("input");
			});
			
			const $total_page = $("<div id='total_page'>共1頁</div>");
			$total_page.css({width: "100%"});
			$("#page").append($total_page);
		}
		
		function check_progress() {
			const formdata = new FormData();
			formdata.append("id", id);
			formdata.append("now", now);
			formdata.append("mode", mode);
			
			$.ajax({
				url: "./check_status.php",
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function(response) {
					const return_data = JSON.parse(response);
					const status = return_data[0];
					
					if (status == "finished") {
						$progress.text("完成");
						$spinnerSector.css( {borderColor : "lightgreen", animation: "none"} );
						
						const output_path = "./application/results/" + return_data[1];
						
						const zip_path = output_path.substring(0, output_path.lastIndexOf("/")+1);
						formdata.append("zip_path", zip_path);
						
						const $download = $("<div></div>");
						const $btn = $("<button>下載全部</button>").css({margin: "0px"});
						$download.append($btn);
						$download.attr("class", "buttons");
						
						$("#download").append($download);
						
						$btn.on("click", function() {
							$btn.text("檔案壓縮中...");
							$btn.attr("disabled", true);
							$btn.css({opacity: 0.6, cursor: "not-allowed"});
							$.ajax({
								url: "./zip_output.php",
								type: "POST",
								data: formdata,
								processData: false,
								contentType: false,
								success: function(response) {
									const zip_output = JSON.parse(response);
									
									if (zip_output == "error")
										$btn.text("檔案毀損，無法下載");
									else {
										$link = $("<a></a>").attr("href", zip_output);
										$link.attr("download", "results.zip");
										
										$("body").append($link);
										$link[0].click();
										$link.remove();
										
										$btn.text("下載全部");
										$btn.attr("disabled", false);
										$btn.css({opacity: 1, cursor: "pointer"});
									}
								}
							})
						});
						
						if (mode == "image") {
							const license_plates = return_data[2];

							const $output = $("<div></div>");
							
							const $img = $("<img>").attr("src", output_path);
							$img.css({maxWidth: "90%", maxHeight: "500px"});
							const $license_plates = $("<p></p>");
							
							if (license_plates.length > 1) {
								let license_plate = license_plates[0];
								if (license_plate == "無法辨識")
									license_plate += "車牌";
								
								$license_plates.append(license_plates);
								for (let i = 1; i < license_plates.length; i++) {
									let license_plate = license_plates[i];
									if (license_plate == "無法辨識")
										license_plate += "車牌";			
									$license_plates.append(license_plates);
								}
							}
							else {
								let license_plate = license_plates[0];
								if (license_plate == "無法辨識")
									license_plate += "車牌";
								$license_plates.text(license_plate);
							}
							
							$output.append($img);
							$output.append($license_plates);
							$("#output").append($output);
							$output.css({opacity: 0}).animate({opacity: 1}, 500);
						}
						else {
							const $output = $("<video></video>").attr("controls", true);
							$("<source>").attr("src", output_path).appendTo($output);
							$output.css({margin: "20px", maxWidth: "90%"});
							$("#output").append($output);
							$output.css({opacity: 0}).animate({opacity: 1}, 500);
						}
					}
					else if (status == "error") {
						$progress.html("錯誤！<br>請重新上傳");
						$spinnerSector.css( {borderColor : "red", animation: "none"} );
					}
					else {
						if (status == "detecting" || status == "uploading")
							$progress.text("處理中");
						else
							$progress.html("處理中<br>" + status);
						setTimeout(check_progress, 2000);
					}
				}
			});

			if (mode == "video") {
				$.ajax({
					url: "./check_no_hel.php",
					type: "POST",
					data: formdata,
					processData: false,
					contentType: false,
					success: function(response) {
						const return_data = JSON.parse(response);
					
						const path = return_data.path;
						if (path != "") {
							const no_hels = return_data.no_hels;
							const license_plates = return_data.license_plates;
							const times = return_data.frame_times;
							
							no_hels.forEach((frame_num, index) => {
								let license_plate = license_plates[index];
								let frame_time = times[index];
								if (license_plate == "無法辨識")
									license_plate += "車牌";
								
								if (images.length > 0){
									if (images[images.length-1][0] == frame_num) {
										if ((page * frames_per_page) > images.length && images.length > ((page-1) * frames_per_page - 1)) {
											$(`#LP_${frame_num}`).append(" / "+license_plate);
										}
										images[images.length-1].push(license_plate);
									}
									else{
										if ((page * frames_per_page) > images.length && images.length > ((page-1) * frames_per_page - 1)) {
											frame_path = "./application/results/" + path + "no_hel_frame/";
											add_frame(frame_num, license_plate);
											add_time(frame_num, frame_time);
										}
										
										images.push([frame_num, license_plate]);
										frame_times.push(frame_time);
									}
									
									if ((images.length - 1) % frames_per_page == 0) {
										total_page = parseInt(images.length / frames_per_page) + 1;
										$("#page_num").attr("max", total_page);
										$("#total_page").text("共" + total_page + "頁");
									}
								}
								else {
									if ((page * frames_per_page) > images.length && images.length > ((page-1) * frames_per_page - 1)) {
										frame_path = "./application/results/" + path + "no_hel_frame/";
										add_frame(frame_num, license_plate);
										add_time(frame_num, frame_time);
									}
									images.push([frame_num, license_plate]);
									frame_times.push(frame_time);
								}
							});
							now = no_hels[no_hels.length - 1];
						}
					}
				});
			}
		}
		
		function add_frame(frame_num, license_plate) {
			const $div = $("<div></div>");
			$div.attr("class", "frame");

			const $img = $("<img>").attr("src", frame_path + frame_num +".jpg");
			const $license_plates = $("<p></p>");
			$license_plates.attr("id", "LP_" + frame_num);
			$license_plates.css({"display": "inline"});
			$license_plates.html(license_plate);
			
			$div.append($img);
			$div.append($license_plates);
			$div.append($("<span></span>"));
			$("#images").append($div);
			$div.css({opacity: 0}).animate({opacity: 1}, 1000);
		}
		
		function add_time(frame_num, frame_time) {
			let second = parseInt(frame_time);
			let minute = parseInt(second / 60);
			second = second % 60;
			let hour = parseInt(minute / 60);
			minute = minute % 60;
			$(`#LP_${frame_num}`).next().text(` (${hour<10 ? "0" : ""}${hour}:${minute<10 ? "0" : ""}${minute}:${second<10 ? "0" : ""}${second})`);
		}
		
		check_progress();
		
		$("body").on("click", "img", function(){
			const $div = $("<div></div>");
			$div.css({backgroundColor: "#BEBEBE", padding: "30px", borderRadius: "10px", border: "2px dashed", maxWidth: "55%"});
			const $img = $("<img>").attr("src", $(this).attr("src"));
			$img.css({height: "100%", width: "100%", maxHeight: "600px"});
			const $p = $("<p></p>").text($(this).next().text());
			$p.css({fontSize: "40px", fontWeight: "bolder", textAlign: "center", margin: "10px 0 0 0"});
			
			$div.append($img);
			$div.append($p);
			$("#enlarge").append($div);
			
			$("#enlarge").show();
			$div.css({opacity: 0}).animate({opacity: 1}, 300);
		});
		
		$('#enlarge').on("click", function(){
			$(this).html("");
			$(this).hide();
		});
	});
</script>
</body>
</html>