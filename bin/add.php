<?php

require "../functions/cosntants.inc.php";

if (isset($_GET["nc"], $_GET["t"], $_GET["nv"], $_GET["v"])) {
	$no_capteur = $_GET["nc"];
	$no_valeur = $_GET["nv"];
	$valeur = $_GET["v"];
	$token = $_GET["t"];
	if ($token == TOKEN) {
		try {
			$db = new PDO("sqlite:../data/db.sqlite");
		} catch (Exception $e) {
			echo 'db:' . $e->getMessage();
		}
		$req = $db->prepare("INSERT INTO data(no_capt, no_val, val) VALUES (:no_capt, :no_val, :val)");
		try {
			$req->execute(array(
				"no_capt" => $no_capteur,
				"no_val" => $no_valeur,
				"val" => "$valeur"
			));
		} catch (Exception $e) {
			echo 'db:' . $e->getMessage();
		}
		echo "k";
	} else {
		echo 'et';
	}
} else {
	echo "ep";
}
?>