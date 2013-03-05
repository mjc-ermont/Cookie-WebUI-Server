<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

require "../functions/cosntants.inc.php";

if (file_exists(PATH_CHRONO)) {
	echo file_get_contents(PATH_CHRONO);
} else {
	echo "f";
}
?>