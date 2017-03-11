<?php
require_once __DIR__ . '/../Battlefleet/Object.class.php';
require_once __DIR__ . '/../Battlefleet/Battlefleet.class.php';
require_once __DIR__ . '/../Spaceship/Spaceship.class.php';

abstract class Weapon extends Object implements JsonSerializable {
	protected $_charge = 0;
	protected $_short = 1; // max short range
	protected $_middle = 2; // max middle range
	protected $_long = 3; // max long range
	protected $_extraCharge = 0;

	private static $_idCounter = 0;

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
		parent::__construct(self::$_idCounter);
		self::$_idCounter++;
	}

	public function display() {
		echo "\tcharge: " . $this->_charge;
		echo "\n\tshort: " . $this->_short;
		echo "\n\tmiddle: " . $this->_middle;
		echo "\n\tlong: " . $this->_long;
	}

	public function addCharge( $c ) {
		$this->_extraCharge += $c;
	}

	public function resetCharge( $c ) {
		$this->_extraCharge = 0;
	}

	public function shoot( $shooter, &$map ) {
		if (!($shooter instanceof Spaceship)) {
			// error
			return;
		}
		$charge = $this->_charge + $this->_extraCharge;
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