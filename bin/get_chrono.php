<?php

require '../constants.inc.php';

if (file_exists(PATH_CHRONO)) {
	file_get_contents(PATH_CHRONO);
} else {
	echo "f";
}
?>