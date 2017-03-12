<?php
require_once __DIR__ . '/../Battlefleet/Battlefleet.class.php';
require_once 'Weapon.class.php';

class NauticalLance extends Weapon {
	public static function doc() {
		return file_get_contents('./NauticalLance.doc.txt');
	}

	public function __construct( $owner = null, $ship = null ) {
		parent::__construct(array('charge' => 0, 'damage' => 1, 'short' => 10, 'middle' => 20, 'long' => 30, 'owner' => $owner, 'ship' => $ship));
	}

	// Low priority, will not be completed anytime soon due to:
	// Extra $direction parameter
	// Ugly collision detection/computation

	// public function shoot( $map, $direction ) {
	// 	if ($direction != Battlefleet::E && $direction != Battlefleet::W) {
	// 		// error
	// 		return;
	// 	}
	// 	$direction = ($direction + $this->_ship->getDirection()) % 4;
	// 	$charge = $this->_charge + $this->_extraCharge;
	// 	$roll = Battlefleet::rollDice($charge);
	// 	$longDmg = $roll[6];
	// 	$middleDmg = $longDmg + $roll[5];
	// 	$shortDmg = $middleDmg + $roll[4];
	// 	$hor = $this->_ship->getHor();
	// 	$ver = $this->_ship->getVer();
	// 	$dirx = (2 - $direction) % 2;
	// 	$diry = ($direction - 1) % 2;
	// 	if ($dirx !== 0) {
	// 		$pts = array_fill()
	// 	}
	// 	$c = $this->_ship->getX() + floor((($dirx + 1) * ($hor - 1)) / 2);
	// 	$r = $this->_ship->getY() + floor((($diry + 1) * ($ver - 1)) / 2);
	// 	// not technically correct, just an approximation for the center of the ship
	// 	for ($dist = 1; $dist <= $this->_long; $dist++) {
	// 		$c += $dirx;
	// 		$r += $diry;
	// 		if ($map[$r][$c] !== null) {
	// 			if ($dist <= $this->_short) {
	// 				$map[$r][$c]->takeDamage($shortDmg * $this->_damage);
	// 			}
	// 			else if ($dist <= $this->_middle) {
	// 				$map[$r][$c]->takeDamage($middleDmg * $this->_damage);
	// 			}
	// 			else {
	// 				$map[$r][$c]->takeDamage($longDmg * $this->_damage);
	// 			}
	// 			break;
	// 		}
	// 	}
	// }
}
?>