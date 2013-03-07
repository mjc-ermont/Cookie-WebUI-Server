<?php

require "../functions/cosntants.inc.php";

if (isset($_GET["nc"], $_GET["t"], $_GET["nv"], $_GET["v"])) {
	$no_capteur = (int)$_GET["nc"];
	$no_valeur = (int)$_GET["nv"];
	$valeur = (float)$_GET["v"];
	$token = $_GET["t"];
	$time = (isset($_GET["ti"])) ? $_GET["ti"] : time();
	
	if ($token == TOKEN) {
	
		$fi = fopen('../data/data.json', 'r');
		if (!$fi){
			die();
		}
		while (!(flock($fi, LOCK_EX)));
		$data = json_decode(fread($fi, filesize("../data/data.json")), TRUE);
		flock($fi, LOCK_UN);
		fclose($fi);

//		if (isset($data["$no_capteur"]["$no_valeur"])) {
			$data[$no_capteur][$no_valeur][] = array($time, $valeur); 
			//$data[$no_capteur][$no_valeur][1][] = $valeur; 
//		} else {
//			$data["$no_capteur"]["$no_valeur"]/*[$time]*/ = array();//array("$no_capteur" => array("$no_valeur" => array($valeur, $time)));
//		}
		
		$fh = fopen('../data/data.json', 'a');
		if (!($fh)){
			die();
		}
		while (!(flock($fh, LOCK_EX)));
		ftruncate($fh, 0);
		fwrite($fh, json_encode($data));
		fflush($fh);
		flock($fh, LOCK_UN);
		fclose($fh);
		echo "k";
	} else {
		echo 'et';
	}
} else {
	echo "ep";
}
?>