<?php
function fp_process_check($link) {
	$sql = "SELECT fpp_no, p_state, min(p_deadline) FROM sub_process WHERE p_state = '加工中' or p_state = '材料未運達' GROUP BY fpp_no;";

	mysqli_select_db($link,"company");
	$process = mysqli_query($link,$sql);
	
	date_default_timezone_set("Asia/Taipei");
	$now = strtotime("now");
	$warn_fpp_no = array();
	while($row = mysqli_fetch_assoc($process)) {
		$seconds = strtotime($row["min(p_deadline)"]) - $now;

		$day = $seconds/86400;
		$day = intval($day);
		
		if($day < 2) {
			array_push($warn_fpp_no,$row["fpp_no"]);
		}
	}
	return $warn_fpp_no;
}

function sub_process_check($link, $fpp_no) {
	$sql = "SELECT sp_num, p_state, p_deadline FROM sub_process WHERE (p_state = '加工中' or p_state = '材料未運達') and fpp_no = '".$fpp_no."';";

	mysqli_select_db($link,"company");
	$process = mysqli_query($link,$sql);
	
	date_default_timezone_set("Asia/Taipei");
	$now = strtotime("now");
	$warn_sp_num = array();
	while($row = mysqli_fetch_assoc($process)) {
		$seconds = strtotime($row["p_deadline"]) - $now;

		$day = $seconds/86400;
		$day = intval($day);
		
		if($day < 2) {
			array_push($warn_sp_num,$row["sp_num"]);
		}
	}
	return $warn_sp_num;
}
?>