<?php

ob_start();
header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

if (isset($_GET["t"])) {
	$data_out = array();
	$time = $_GET["t"];
	$nb_val = $_GET["n"];
	$fi = fopen('../data/data.json', 'r');
	$data = json_decode(fread($fi, filesize("../data/data.json")), TRUE);
	fclose($fi);
	
	if (isset($_GET["c"])&& isset($_GET["v"])){
		foreach ($data[$_GET["c"]][$_GET["v"]] as $no_data => $val) {
			if ((int) $data[$_GET["c"]][$_GET["v"]][$no_data][0] > (int) $time) {
				$data_out[] = $data[$_GET["c"]][$_GET["v"]][$no_data];
				//$data_out[1][] = (int)$data[$_GET["c"]][$_GET["v"]][1][$no_data];
			}
		}
		$data_out = array_slice($data_out, -$nb_val);
		//$data_out[1] = array_slice($data_out[1], -$nb_val);

	} else if (isset($_GET["c"])){
		foreach ($data[$_GET["c"]] as $no_val => $value) {
			foreach ($value as $no_data => $val) {
				if ((int) $value[$no_data][0] > (int) $time) {
					$data_out[$no_val][] = $value[$no_data];
//					$data_out[$no_val][1][] = (int)$value[1][$no_data];
				}
			}
			$data_out[$no_val] = array_slice($data_out[$no_val], -$nb_val);
//			$data_out[$no_val][1] = array_slice($data_out[$no_val][1], -$nb_val);
		}
	} else {
		foreach ($data as $no_capt => $value_a) {
			foreach ($value_a as $no_val => $value) {
				foreach ($value as $no_data => $val) {
					if ((int) $value[$no_data][0] > (int) $time) {
						$data_out[$no_capt][$no_val][] = $value[$no_data];
//						$data_out[$no_capt][$no_val][1][] = (int)$value[1][$no_data];
					}
				}
				$data_out[$no_capt][$no_val] = array_slice($data_out[$no_capt][$no_val], -$nb_val);
				//$data_out[$no_capt][$no_val][1] = array_slice($data_out[$no_capt][$no_val][1], -$nb_val);
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