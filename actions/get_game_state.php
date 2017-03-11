<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	date_default_timezone_set('America/Los_Angeles');
	require_once __DIR__ . '/../classes/Battlefleet/Battlefleet.class.php';
	require_once __DIR__ . '/../classes/Spaceship/Faction/Imperial/ImperialFrigate.class.php';
	require_once __DIR__ . '/../classes/Weapon/NauticalLance.class.php';
	
	$bf = new Battlefleet();
	$ship = new ImperialFrigate(0, 0);
	$ship2 = new ImperialFrigate(0, 0);
	$bf->getCurrentPlayer()->addShip($ship);
	$bf->getCurrentPlayer()->addShip($ship2);

	echo json_encode($bf);
?>