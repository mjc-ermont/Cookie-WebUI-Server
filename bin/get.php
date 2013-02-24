<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");
if (isset($_GET["t"])) {
	$data = array();
	$time = $_GET["t"];
	try {
		$db = new PDO("sqlite:../data/db.sqlite");
	} catch (Exception $e) {
		echo 'db:' . $e->getMessage();
	}

	$req = $db->prepare("SELECT no_capt, no_val, val, time FROM data WHERE time > ?");
	$req->execute(array($time));
	//$data = $req->fetchAll(PDO::FETCH_NUM);
	while($rep = $req->fetch()){
		if (!(isset($data[(int)$rep["no_capt"]][(int)$rep["no_val"]]))){
			$data[(int)$rep["no_capt"]][(int)$rep["no_val"]] = array();
		}
		array_push($data[(int)$rep["no_capt"]][(int)$rep["no_val"]], array((int)$rep["val"], (int)$rep["time"]));
	}
	//var_dump($data);
	if (count($data)) {
		echo json_encode($data);
	} else {
		echo "n";
	}
} else {
	echo "p";
}
?>