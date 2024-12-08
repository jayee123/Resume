<?php
	function exec_recognition_python($source="") {
		$command = "conda activate";
		$command .= " && conda activate onnx";
		$command .= " && python application/system.py " . $source;
		pclose(popen($command,"r"));
	}
	
	function exec_recognition_cpp($source, $id) {
		$command = "start /b application/system_c++.exe " . escapeshellarg($source) . " " . $id . " 0.8 > NUL 2>&1";
		pclose(popen($command,"r"));
	}
?>