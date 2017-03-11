<?php
require_once __DIR__ . '/../Battlefleet/Battlefleet.class.php';
require_once __DIR__ . '/../Spaceship/Spaceship.class.php';

abstract class Weapon {
	private $_charge = 0;
	private $_short = 1; // max short range
	private $_middle = 2; // max middle range
	private $_long = 3; // max long range

	public static function doc() {
		return file_get_contents('./Weapon.doc.txt');
	}

	public function __construct( array $kwargs ) {
		if (array_key_exists('charge', $kwargs)) {
			$this->_charge = $kwargs['charge'];
		}
		if (array_key_exists('short', $kwargs)) {
			$this->_short = $kwargs['short'];
		}
		if (array_key_exists('middle', $kwargs)) {
			$this->_middle = $kwargs['middle'];
		}
		if (array_key_exists('long', $kwargs)) {
			$this->_long = $kwargs['long'];
		}
	}

	public function shoot( Spaceship $shooter, $charge, array $ships ) {
		$charge += $this->_charge;
		$roll = Battlefleet::rollDice($speed);
		$longDmg = $roll[6];
		$middleDmg = $longDmg + $roll[5];
		$shortDmg = $middleDmg + $roll[4];
		$hor = ($shooter->getDirection() % 2) ? $shooter->getWidth() : $shooter->getLength();
		$ver = ($shooter->getDirection() % 2) ? $shooter->getLength() : $shooter->getWidth();
		$dirx = (2 - $shooter->getDirection()) % 2;
		$diry = ($shooter->getDirection() - 1) % 2;
		$startx = $shooter->getX() + floor((($dirx + 1) * ($hor - 1)) / 2);
		$starty = $shooter->getY() + floor((($diry + 1) * ($ver - 1)) / 2);
		// not technically correct, just an approximation for the center of the ship
		for ($dist = 1; $dist <= $this->_long; $dist++) {
			// pseudocode for basic shooting:
			// if ($startx, $starty) is in $ship
			//      if $dist < $this->_short
			//           $ship->takeDamage($shortDmg);
			//      else if $dist < $this->_middle
			//           $ship->takeDamage($middleDmg);
			//      else if $dist < $this->_long
			//           $ship->takeDamage($longDmg);
			//      break;
			//  }
			$startx++;
			$starty++;
		}
	}
}
?>