<?php
require_once __DIR__ . '/../Battlefleet/Object.class.php';
require_once __DIR__ . '/../Battlefleet/Battlefleet.class.php';
require_once __DIR__ . '/../Battlefleet/Player.class.php';
require_once __DIR__ . '/../Spaceship/Spaceship.class.php';

abstract class Weapon extends Object implements JsonSerializable {
	protected $_charge = 0;
	protected $_damage = 1; // base damage
	protected $_short = 30; // max short range
	protected $_middle = 60; // max middle range
	protected $_long = 90; // max long range
	protected $_owner = null;
	protected $_ship = null;

	protected $_extraCharge = 0;

	private static $_idCounter = 0;

	public static function doc() {
		return file_get_contents('./Weapon.doc.txt');
	}

	public function __construct( array $kwargs ) {
		if (array_key_exists('charge', $kwargs)) {
			$this->_charge = $kwargs['charge'];
		}
		if (array_key_exists('damage', $kwargs)) {
			$this->_damage = $kwargs['damage'];
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
		if (array_key_exists('owner', $kwargs)) {
			$this->_owner = $kwargs['owner'];
		}
		if (array_key_exists('ship', $kwargs)) {
			$this->_ship = $kwargs['ship'];
		}
		parent::__construct(self::$_idCounter);
		self::$_idCounter++;
	}

	public function display() {
		echo get_class($this) . PHP_EOL;
		echo "\tcharge: " . $this->_charge;
		echo "\n\tshort: " . $this->_short;
		echo "\n\tmiddle: " . $this->_middle;
		echo "\n\tlong: " . $this->_long;
	}

	public function getOwner() {
		return $this->_owner;
	}

	public function getShip() {
		return $this->_ship;
	}

	public function setOwner( $owner ) {
		if ($owner instanceof Player) {
			$this->_owner = $owner;
		}
		else {
			// error
		}
	}

	public function setShip( $ship ) {
		if ($ship instanceof Spaceship) {
			$this->_ship = $ship;
		}
		else {
			// error
		}
	}

	public function addCharge( $c ) {
		$this->_extraCharge += $c;
	}

	public function resetCharge( $c ) {
		$this->_extraCharge = 0;
	}

	// This is a basic shoot function for weapons that shoot one straight line
	// from the front of the ship.
	// It should be changed for weapons that have different effects.
	public function shoot( $map ) {
		$charge = $this->_charge + $this->_extraCharge;
		$roll = Battlefleet::rollDice($charge);
		$longDmg = $roll[6];
		$middleDmg = $longDmg + $roll[5];
		$shortDmg = $middleDmg + $roll[4];
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
			if ($r >= 0 && $r < Battlefleet::MAP_LEN && $c >= 0 && $c < Battlefleet::MAP_WIDTH && $map[$r][$c] !== null) {
				if ($dist <= $this->_short) {
					$map[$r][$c]->takeDamage($shortDmg * $this->_damage);
				}
				else if ($dist <= $this->_middle) {
					$map[$r][$c]->takeDamage($middleDmg * $this->_damage);
				}
				else {
					$map[$r][$c]->takeDamage($longDmg * $this->_damage);
				}
				return [$r, $c]; // Used for MacroCanon
			}
		}
		return null;
	}

	public function jsonSerialize() {
        return (object)array(
        	"_id" => $this->_id,
        	"charge" => $this->_charge,
			"short" => $this->_short,
			"middle" => $this->_middle,
			"long" => $this->_long,
			"extraCharge" => $this->_extraCharge
        );
    }
}
?>