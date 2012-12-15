<?php
include_once "../functions/trame/check_trame.inc.php";

if (isset($_GET["tr"]) && isset($_GET["token"])){
	$tr = $_GET["tr"];
	
	if (check_trame($tr)){
		$out = fopen("../data/data.tr", "a+");
		fwrite($out, "$tr\n");
		fclose($out);
		echo "ok";
	} else {
		echo "err_corrupt";
	}
} else {
	echo "err_param";
}
?>
