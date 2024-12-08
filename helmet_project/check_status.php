<?php
	if (isset($_POST["id"])) {
		include_once("dbtools.inc.php");
		$conn = create_connection();
		
		$sql = "SELECT output_path, status FROM fileinfo WHERE fid = '" . $_POST["id"] . "';";
		$row = mysqli_fetch_assoc(execute_sql($conn, "helmet", $sql));
		if (isset($row["status"]))
			$status = $row["status"];
		else 
			$status = "error";
		
		if ($status == "finished") {
			$output_path = $row["output_path"];
			
			$output_path = substr($output_path, 51);
			
			$return_data = [$status, $output_path];
			if ($_POST["mode"] == "image") {
				$sql = "SELECT license_plate FROM no_hel_frame_record WHERE fid = '" . $_POST["id"] . "';";
				$result = execute_sql($conn, "helmet", $sql);
				if (mysqli_num_rows($result) > 0) {
					$license_plates = array();
					while ($row = mysqli_fetch_assoc($result)) {
						$license_plate = $row["license_plate"];
						array_push($license_plates, $license_plate);
					}
					array_push($return_data, $license_plates);
				}
				else {
					array_push($return_data, ["無未戴安全帽者"]);
				}
			}
			echo json_encode($return_data);
		}
		else {
			$return_data = [$status];
			echo json_encode($return_data);
		}
	}
	else
		header("Location: upload.html");
?>