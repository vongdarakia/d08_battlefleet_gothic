<?php 
	$bf = new Battlefleet();
	$ship = new ImperialFrigate(0, 0);
	$ship2 = new ImperialFrigate(0, 0);
	$bf->getCurrentPlayer()->addShip($ship);
	$bf->getCurrentPlayer()->addShip($ship2);

	echo json_encode($bf);
?>