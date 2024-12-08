<?php
	if (isset($_POST["id"]) && isset($_POST["zip_path"])) {
		$source = $_POST["zip_path"];
		$zip_output = $_POST["zip_path"] . "results.zip";

		if (file_exists($zip_output)) {
			echo json_encode($zip_output);
		}
		else {
			$zip = new ZipArchive();
			
			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source,
													RecursiveIteratorIterator::LEAVES_ONLY));

			if ($zip->open($zip_output, ZipArchive::CREATE) !== TRUE) {
				echo json_encode("error");
				return;
			}
			
			foreach($files as $file) {
				if (!$file->isDir()) {
					$file_path = $file->getRealPath();
					$relative_path = substr($file_path, 51 + strlen($_POST["id"]) + 1);
					
					$zip->addFile($file_path, $relative_path);
				}
			}
			
			$zip->close();
			echo json_encode($zip_output);
		}
	}
	else
		header("Location: upload.html");
?>