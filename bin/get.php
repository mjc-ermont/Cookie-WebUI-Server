<?php
if (isset($_GET["t"])) {
	$time = $_GET["t"];
	try {
		$db = new PDO("sqlite:../data/db.sqlite");
	} catch (Exception $e) {
		echo 'db:' . $e->getMessage();
	}

	$req = $db->prepare("SELECT no_capt, no_val, val, time FROM data WHERE time > ?");
	$req->execute(array($time));
	$data = $req->fetchAll(PDO::FETCH_NUM);
	echo json_encode($data);
}
?>