<?php
function roll( $n ) {
	$count = array(0, 0, 0, 0, 0, 0, 0);
	for ($i = 0; $i < $n; $i++) {
		$count[rand(1, 6)]++;
	}
	return $count;
}
?>