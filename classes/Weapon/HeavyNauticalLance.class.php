<?php
require_once 'Weapon.class.php';

class HeavyNauticalLance extends Weapon {
	public static function doc() {
		return file_get_contents('./HeavyNauticalLance.doc.txt');
	}

	public function __construct( $ship = null, $owner = null ) {
		parent::__construct(array('charge' => 0, 'damage' => 2, 'short' => 30, 'middle' => 60, 'long' => 90, 'owner' => $owner, 'ship' => $ship));
	}

	// shooting is in the same format as the default Weapon class
	// charge and roll calculations are done inside the for loop
	public function shoot( $map ) {
		if (!$this->_ship->isStationary()) { 
			// can't shoot if not stationary
			return null;
		}
		$hor = $this->_ship->getHor();
		$ver = $this->_ship->getVer();
		$dirx = (2 - $this->_ship->getDirection()) % 2;
		$diry = ($this->_ship->getDirection() - 1) % 2;
		$c = $this->_ship->getX() + floor((($dirx + 1) * ($hor - 1)) / 2);
		$r = $this->_ship->getY() + floor((($diry + 1) * ($ver - 1)) / 2);
		// not technically correct, just an approximation for the center of the ship
		for ($dist = 1; $dist <= $this->_long; $dist++) {
			$c += $dirx;
			$r += $diry;
			if (Battlefleet::inMap($r, $c) && $map[$r][$c] !== null) {
				$charge = $this->_charge + $this->_extraCharge;
				$roll = Battlefleet::rollDice($charge);
				$longDmg = $roll[6];
				$middleDmg = $longDmg + $roll[5];
				$shortDmg = $middleDmg + $roll[4];
				if ($dist <= $this->_short) {
					$map[$r][$c]->takeDamage($shortDmg * $this->_damage);
				}
				else if ($dist <= $this->_middle) {
					$map[$r][$c]->takeDamage($middleDmg * $this->_damage);
				}
				else {
					$map[$r][$c]->takeDamage($longDmg * $this->_damage);
				}
				if (!$map[$r][$c]->isDead()) {
					return [$r, $c];
				}
			}
		}
		return null;
	}
}
?>