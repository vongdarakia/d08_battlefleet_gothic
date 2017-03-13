<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Los_Angeles');
require_once './actions/game_save.php';
require_once './classes/Battlefleet/Battlefleet.class.php';
require_once './classes/Spaceship/Faction/Imperial/ImperialFrigate.class.php';
require_once './classes/Spaceship/Faction/Imperial/ImperialIronclad.class.php';
require_once './classes/Weapon/NauticalLance.class.php';

Battlefleet::$verbose = true;

$bf = new Battlefleet();
$ship = new ImperialIronclad(5, 71);
$ship2 = new ImperialFrigate(5, 83);
$ship3 = new ImperialIronclad(5, 65);
$ship4 = new ImperialIronclad(140, 90);
// $ship->addWeapon(new NauticalLance());
// $id = 0;
// $id++;
// echo $id;
// $ship->moveShip(4, $bf->getMap()); 

$bf->getCurrentPlayer()->addShip($ship);
$bf->getCurrentPlayer()->addShip($ship2);
$bf->getCurrentPlayer()->addShip($ship3);
$bf->getCurrentPlayer()->addShip($ship4);
$bf->updateMap();

$ship->getWeapons()[0]->addCharge(20);
$ship->getWeapons()[0]->shoot($bf->getMap());
echo $ship->getHP() . '  ' . $ship2->getHP() . PHP_EOL;
// $bf->updateShips();
$bf->updateMap();

saveGame($bf, './private/game');

$ship2->display();
// $bf->nextPhase();
while (true) {
	if (!(selectPhaseOption1($bf)))
		$bf->endTurn() ;
}

function selectPhaseOption1( $bf ) {
	$option = readline("Phase ". ($bf->getCurrentPhase() + 1) ." \n"
		. "\t[1] Select Ship\n"
		. "\t[2] Damage Ship\n"
		. "\t[m] Display Map\n"
		. "\t[0] End Turn\n"
		. $bf->getCurrentPlayer() . ": "
	);

	if ($option == "1") {
		echo PHP_EOL;
		selectShip($bf->getCurrentPlayer(), $bf->getCurrentPhase(), $bf);
	}

	if ($option == "2") {
		echo PHP_EOL;
		echo "Ship took 2 damage\n";
		$ship = $bf->getCurrentPlayer()->getShips()[0];
		$ship->takeDamage(2);
		$ship->display();
	}

	if ($option == "m") {
		echo PHP_EOL;
		$bf->updateMap();
		$bf->displayMap();
	}

	if ($option == "0")
		return 0;
	return 1;
}

function selectShip( $player, $phase, $bf ) {
	$ships = $player->getShips();
	if (count($ships) > 0) {
		echo "Select ship:\n";
		foreach ($player->getShips() as $key => $ship) {
			echo "\t[{$key}] {$ship}\n";
		}
		echo PHP_EOL;

		$option = readline($player . ": ");
		if (array_key_exists($option, $ships)) {
			if ($phase == 0)
				selectPPOption($option, $ships[$option], $player);
			else if ($phase == 1)
				selectMove($option, $ships[$option], $bf);
			else if ($phase == 2)
				selectShoot($option, $ships[$option], $bf);
		}
		else {
			echo "Invalid option" . PHP_EOL;
		}
		// if ($option == "1") {
		// 	echo PHP_EOL;
			
		// }
	}
	else {
		echo "You have no ships\n\n";
	}
}

function selectMove( $shipIdx, $ship, $bf) {
	while (True) {
		$option = readline("Select Move\n"
			. "\t[1] Turn Ship\n"
			. "\t[2] Move Ship\n"
			. "\t[i] Ship status\n"
			. "\t[m] Display Map\n"
			. "\t[0] End Turn\n"
			. $bf->getCurrentPlayer() . ": "
		);

		if ($option == "1") {
			echo PHP_EOL;
			$dir = readline("Select direction (1 or -1)\n"
				. $bf->getCurrentPlayer() . ": "
			);
			if (!($ship->turnShip($dir, $bf->getMap())))
				echo "Error: direction must be 1 or -1\n";
		}

		else if ($option == "2" ) {
			echo PHP_EOL;
			$dist = intval(readline("Select distance\n"
				. $bf->getCurrentPlayer() . ": "
			));
			echo $dist . " selected" . PHP_EOL;
			$ship->moveShip($dist, $bf->getMap());
		}

		else if ($option == "m") {
			echo PHP_EOL;
			$bf->updateMap();
			$bf->displayMap();
		}

		else if ($option == "i") {
			echo PHP_EOL;
			echo "HP: " . $ship->getHP() . PHP_EOL
			. "Speed: " . $ship->getSpeed() . PHP_EOL
			. "Moved Dist: ". $ship->getMovedDist() . PHP_EOL
			. "Stationary:" . $ship->isStationary() . PHP_EOL;
		}

		else
			break ;
	}
}

function selectShoot( $shipIdx, $ship, $bf) {
	
	while (True) {
		if (empty($ship->getWeapons())) {
			echo "This ship has no weapons installed\n";
			break ;
		}
		$ship->display();
		$shp_count = count($bf->getAllShips());
		$option = readline("Choose option\n"
			. "\t[a] Attack\n"
			. "\t[1-".$shp_count."] Display ship info\n"
			. "\t[m] Display Map\n"
			. "\t[q] End Turn\n"
			. $bf->getCurrentPlayer() . ": "
		);

		if ($option == "a") {
			$ship->getWeapons()[0]->new_shoot($bf->getMap(), 1);
		}

		else if (intval($option) >= 1 && intval($option) <= $shp_count - 1) {
			echo PHP_EOL;
			$tmp_ship = $bf->getAllShips()[intval($option)];
			echo "HP: " . $tmp_ship->getHP() . PHP_EOL
			. "Shield: " . $tmp_ship->getShield() . PHP_EOL
			. "Stationary:" . $tmp_ship->isStationary() . PHP_EOL;
		}

		else if ($option == "m") {
			echo PHP_EOL;
			$bf->updateMap();
			$bf->displayMap();
		}

		else
			break ;
	}
}

function selectPPOption($shipIdx, $ship, $player) {
	echo "\nYou've selected " . $ship . PHP_EOL . PHP_EOL;
	echo "What do you want to do?\n";
	echo "\t[0] Increase speed\n";
	echo "\t[1] Increase shield power\n";
	echo "\t[2] Increase weapon charges\n";
	echo "\t[3] Repair ship (must be stationary)\n\n";
	$option = readline($player . ": ");
	promptPPSpendings($shipIdx, $ship, $option, $player);
}

function promptPPSpendings($shipIdx, $ship, $option, $player) {
	// echo "\nHow much PP do you want to spend? ";
	$pp = readline("\nHow much PP do you want to spend? ");
	$pp = intval($pp);
	

	if ($option == "0") {
		echo "\nYou've spent " . $pp . " on more speed for your " . $ship . PHP_EOL . PHP_EOL;
		$ship->spendPP( $pp, 0, [], 0 );
	}
	else if ($option == "1") {
		echo "\nYou've spent " . $pp . " on more shield for your " . $ship . PHP_EOL . PHP_EOL;
		$ship->spendPP( 0, $pp, [], 0 );
	}
	else if ($option == "2") {
		$weapons = [0, 0];
		$weapons[$shipIdx] = $pp;
		echo "\nYou've spent " . $pp . " on more weapon charges for your " . $ship . PHP_EOL . PHP_EOL;
		$ship->spendPP( 0, 0, [$pp], 0 );
	}
	else if ($option == "3") {
		echo "\nYou've spent " . $pp . " on repairing your " . $ship . PHP_EOL . PHP_EOL;
		$ship->spendPP( 0, 0, [], $pp );
	}

	$ship->display();
	echo PHP_EOL;
}



function generateMap($width, $length) {

}

?>
