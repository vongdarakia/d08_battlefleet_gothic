<?php 
	require_once 'get_game.php';

	// $_POST['ship_id']
	$ppSpeed = intval($_POST['speed']);
	$ppShield = intval($_POST['shield']);
	$ppWeapon = intval($_POST['weapon']);
	$ppRepair = intval($_POST['repair']);

	$ship = $game->getShipById(intval($_POST['ship_id']));
	if ($ship) {
		$game->spendPP($ppSpeed, $ppShield, $ppWeapon, $ppRepair);
		saveGame($game, $gameFile);
		echo json_encode($game);
	}
	else {
		echo "Invalid ship ID: '" . $_POST['ship_id'] . "'";
	}
?>