<?php
	if (isset($_POST["upload"])) {
		$file_name = iconv("UTF-8", "Big5", $_FILES["fileUpload"]["name"]);
		$extension = strtolower(substr(strrchr($file_name, "."), 1));

		$image_extension = ["jpg", "jpeg", "png", "gif", "bmp", "tiff", "webp"];
		$video_extension = ["mp4", "avi", "mov", "wmv", "mkv", "flv", "webm", "ts"];
		
		// check extension
		$mode = "";
		if (in_array($extension, $image_extension))
			$mode = "image";
		else if (in_array($extension, $video_extension))
			$mode = "video";

		if ($mode != "") {
			include_once("./check_save_dir.php");

			// check and generate saved directory
			$return_arr = check_save_dir();
			$save_dir = $return_arr[0];
			$id = $return_arr[1];
			$save_path = $save_dir . "/" . $file_name;

			//move the tmp file
			if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $save_path)) {} 
			else {
				$return_data = ["status" => "upload_error"];
				$json = json_encode($return_data);
				echo $json;
				return;
			}
			
			//insert the file record
			include_once("dbtools.inc.php");
			$conn = create_connection();
			date_default_timezone_set("Asia/Taipei");
			$datetime = date("Y-m-d H:i:s");
			$sql = "INSERT INTO fileinfo VALUES ('$id', '$file_name', '$extension', ". $_FILES["fileUpload"]["size"] .
					", '$datetime', '$save_path', '$mode', '', 'uploading');";
			execute_sql($conn, "helmet", $sql);
			
			//execute cpp .exe (background process)
			include_once("exec_recog_com.php");
			exec_recognition_cpp($save_path, $id);
			
			$return_data = ["status" => "success", "id" => $id, "mode" => $mode, "file_name" => $file_name];
			$json = json_encode($return_data);
			sleep(1.5);
			echo $json;
		}
		else {
			$return_data = ["status" => "format_error"];
			$json = json_encode($return_data);
			echo $json;
		}
	}
	else
		header("Location: upload.html");
?>