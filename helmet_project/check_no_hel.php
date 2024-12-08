<?php
	if (isset($_POST["id"]) && isset($_POST["now"])) {
		include_once("dbtools.inc.php");
		$conn = create_connection();
		
		$sql = "SELECT output_path, frame_num, license_plate, frame_time FROM ".
				"(SELECT fid, frame_num, license_plate, frame_time FROM no_hel_frame_record WHERE fid = '" . $_POST["id"] . "' AND frame_num > '" . $_POST["now"] .
				"') as a, (SELECT output_path FROM fileinfo WHERE fid = '" . $_POST["id"] . "') as b ORDER BY frame_num;";

		$result = execute_sql($conn, "helmet", $sql);
		
		if (mysqli_num_rows($result) > 0) {
			if (mysqli_num_fields($result) > 2) {
				$output_path = dirname(mysqli_fetch_assoc($result)["output_path"]) . "/";
				$output_path = substr($output_path, 51);
			}
			else
				$output_path = "";
			
			mysqli_data_seek($result, 0);
			$no_hels = array();
			$license_plates = array();
			$frame_times= array();
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($no_hels, $row["frame_num"]);
				array_push($license_plates, $row["license_plate"]);
				array_push($frame_times, $row["frame_time"]);
			}
			
			$return_data = ["path" => $output_path, "no_hels" => $no_hels, "license_plates" => $license_plates, "frame_times" => $frame_times];
			
			echo json_encode($return_data);
		}
		else {
			$return_data = ["path" => ""];
			echo json_encode($return_data);
		}
	}
	else
		header("Location: upload.html");
?>