<?php
	function check_save_dir() {
		$root = str_replace("\\", "/", realpath(dirname(__FILE__))) . "/source_repository";
		
		date_default_timezone_set("Asia/Taipei");
		$dir = date("Y_m_d");

		$save = $root . "/" . $dir;
		if (!file_exists($save)) {
			$save .= "/1";
			mkdir($save, NULL, True);
			$id = $dir . "_1";
			return [$save, $id];
		}
		
		$dirs_count = count(scandir($save)) - 2;
		$save .= "/" . $dirs_count + 1;
		$id = $dir . "_" . $dirs_count + 1;
		mkdir($save);
		return [$save, $id];
	}
?>