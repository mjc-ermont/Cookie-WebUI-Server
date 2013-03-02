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
		foreach ($data[$_GET["c"]][$_GET["v"]][0] as $no_data => $val) {
			if ((int) $data[$_GET["c"]][$_GET["v"]][1][$no_data] > (int) $time) {
				$data_out[0][] = (int)$data[$_GET["c"]][$_GET["v"]][0][$no_data];
				$data_out[1][] = (int)$data[$_GET["c"]][$_GET["v"]][1][$no_data];
			}
		}
		$data_out[0] = array_slice($data_out[0], -$nb_val);
		$data_out[1] = array_slice($data_out[1], -$nb_val);

	} else if (isset($_GET["c"])){
		foreach ($data[$_GET["c"]] as $no_val => $value) {
			foreach ($value[0] as $no_data => $val) {
				if ((int) $value[1][$no_data] > (int) $time) {
					$data_out[$no_val][0][] = (int)$value[0][$no_data];
					$data_out[$no_val][1][] = (int)$value[1][$no_data];
				}
			}
			$data_out[$no_val][0] = array_slice($data_out[$no_val][0], -$nb_val);
			$data_out[$no_val][1] = array_slice($data_out[$no_val][1], -$nb_val);
		}
	} else {
		foreach ($data as $no_capt => $value_a) {
			foreach ($value_a as $no_val => $value) {
				foreach ($value[0] as $no_data => $val) {
					if ((int) $value[1][$no_data] > (int) $time) {
						$data_out[$no_capt][$no_val][0][] = (int)$value[0][$no_data];
						$data_out[$no_capt][$no_val][1][] = (int)$value[1][$no_data];
					}
				}
				$data_out[$no_capt][$no_val][0] = array_slice($data_out[$no_capt][$no_val][0], -$nb_val);
				$data_out[$no_capt][$no_val][1] = array_slice($data_out[$no_capt][$no_val][1], -$nb_val);
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