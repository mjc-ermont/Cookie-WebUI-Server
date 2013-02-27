<?php
ob_start();
header("Access-Control-Allow-Origin: *");
header("content-type: application/json");
if (isset($_GET["t"])) {
	$data_out = array();
	$last = array();
	$time = $_GET["t"];
	$fi = fopen('../data/data.json', 'r');
	$data = json_decode(fread($fi, filesize("../data/data.json")), TRUE);
	fclose($fi);
	foreach ($data as $time_history => $history) {
		if ($time_history < $time) {
			continue;
		} else {
			foreach ($history as $no_capt => $value_a) {
				foreach ($value_a as $no_val => $value) {
						$data_out[$no_capt][$no_val][0][] = $value[0];
						$data_out[$no_capt][$no_val][1][] = $value[1];
				}
			}
		}
	}
	if (count($data_out)) {
		echo json_encode($data_out);
	} else {
		echo "n";
	}
} else {
	echo "p";
}
ob_end_flush();
?>