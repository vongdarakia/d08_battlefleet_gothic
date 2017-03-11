<?php
require_once __DIR__ . '/../Battlefleet/Battlefleet.class.php';
require_once __DIR__ . '/../Battlefleet/Player.class.php';
require_once __DIR__ . '/../Weapon/Weapon.class.php';

abstract class Spaceship {
	private $_length = 1;
	private $_width = 1;
	private $_hp = 1; // hull/health points
	private $_maxhp = 1; // max hp
	private $_pp = 0; // engine power/power points
	private $_speed = 1; // maximum speed
	private $_handle = 0; // minimum speed
	private $_weapons = array();
	private $_direction = Battlefleet::E; // 0 1 2 3 -> N E S W
	private $_cost = 100;
	private $_name = 'placeholder name';
	private $_x = 0;
	private $_y = 0;
	private $_owner = null;

	private $_shield = 0; // shield
	private $_extraSpeed = 0; // extra speed

	private $_id;
	private static $_idCounter = 0;

	public static function doc() {
		return file_get_contents('./Spaceship.doc.txt');
	}

	public function __construct( array $kwargs ) {
		if (array_key_exists('length', $kwargs)) {
			$this->_length = $kwargs['length'];
		}
		if (array_key_exists('width', $kwargs)) {
			$this->_width = $kwargs['width'];
		}
		if (array_key_exists('hp', $kwargs)) {
			$this->_hp = $kwargs['hp'];
			$this->_maxhp = $this->_hp;
		}
		if (array_key_exists('pp', $kwargs)) {
			$this->_pp = $kwargs['pp'];
		}
		if (array_key_exists('speed', $kwargs)) {
			$this->_speed = $kwargs['speed'];
		}
		if (array_key_exists('handle', $kwargs)) {
			$this->_handle = $kwargs['handle'];
		}
		if (array_key_exists('weapons', $kwargs)) {
			$this->_weapons = $kwargs['weapons'];
		}
		if (array_key_exists('direction', $kwargs)) {
			$this->_direction = $kwargs['direction'];
		}
		if (array_key_exists('cost', $kwargs)) {
			$this->_cost = $kwargs['cost'];
		}
		if (array_key_exists('name', $kwargs)) {
			$this->_name = $kwargs['name'];
		}
		if (array_key_exists('x', $kwargs)) {
			$this->_x = $kwargs['x'];
		}
		if (array_key_exists('y', $kwargs)) {
			$this->_y = $kwargs['y'];
		}
		if (array_key_exists('owner', $kwargs)) {
			$this->_owner = $kwargs['owner'];
		}
		$this->_id = $this->_idCounter;
		$this->_idCounter++;
	}

	public function __toString() {
		return $this->_name . " ({$this->_x}, {$this->_y})";
	}

	public function getLength() {
		return $this->_length;
	}

	public function getWidth() {
		return $this->_width;
	}

	public function getWeapons() {
		return $this->_weapons;
	}

	public function getDirection() {
		return $this->_direction;
	}

	public function getX() {
		return $this->_x;
	}

	public function getY() {
		return $this->_y;
	}

	/*public function getXDir() {
		if ($this->_direction == Battlefleet::N || $this->_direction == Battlefleet::E)
			return 1;
		if ($this->_direction == Battlefleet::S || $this->_direction == Battlefleet::W)
			return -1;
		return 0;
	}

	public function getYDir() {
		if ($this->_direction == Battlefleet::N || $this->_direction == Battlefleet::W)
			return 1;
		if ($this->_direction == Battlefleet::S || $this->_direction == Battlefleet::E)
			return -1;
		return 0;
	}

	public function getXEnd() {
		if ($this->_direction == Battlefleet::N || $this->_direction == Battlefleet::E)
			return $this->_x + $this->_width;
		if ($this->_direction == Battlefleet::S || $this->_direction == Battlefleet::W)
			return $this->_x - $this->_width;
		return $this->_x;
	}

	public function getYEnd() {
		if ($this->_direction == Battlefleet::N || $this->_direction == Battlefleet::W)
			return $this->_y + $this->_length;
		if ($this->_direction == Battlefleet::S || $this->_direction == Battlefleet::E)
			return $this->_y - $this->_length;
		return $this->_y;
	}*/

	// todo: more get functions

	public function spendPP( $speed, $shield, $weapons, $repair ) {
		$pp = $speed + $shield + $repair;

		foreach ($weapon as $key => $amount) {
			$pp += $amount;
		}
		if ($pp > $this->_pp) { 
			// error
			return;
		}
		$this->_extraSpeed += Battlefleet::rollDiceSum($speed);
		$this->_shield += $shield;
		foreach ($this->_weapons as $i => $weapon) {
			if (array_key_exists($i, $weapons)) {
				$this->_weapons[$i]->addCharge($weapons[$i]);
			}
		}
		if (Battlefleet::rollDice($repair)[6] > 0) {
			$this->_hp = $this->_maxhp;
		}
	}

	public function resetPP() {
		$this->_extraSpeed = 0;
		$this->_shield = 0;
		foreach ($this->_weapons as $i => $weapon) {
			$this->_weapons[$i]->resetCharge();
		}
	}

	public function takeDamage( $d ) {
		if ($d <= $this->_shield) {
			$this->_shield -= $d;
		}
		else {
			$this->_hp += $this->_shield;
			$this->_hp -= $d;
			$this->_shield = 0;
		}
	}

	public function isDead() {
		return $this->_hp <= 0;
	}

	// public function addWeapon($weapon) {
	// 	if ($weapon instanceof Weapon) {
	// 		$this->_weapons[] = $weapon;
	// 	}
	// 	else {
	// 		echo "Not a weapon\n";
	// 	}
	// }

	public function setOwner( &$owner ) {
		if ($owner instanceof Player) {
			$this->_owner = $owner;
		}
		else {
			// error
		}
	}

	public function moveShip()

	public function display() {
		echo $this->_name . PHP_EOL;
		echo "\tx: " . $this->_x;
		echo "\n\ty: " . $this->_y;
		echo "\n\tdir: " . $this->_direction;
		echo "\n\tcost: " . $this->_cost;
		echo "\n\tlength: " . $this->_length;
		echo "\n\twidth: " . $this->_width;
		echo "\n\thull: " . $this->_hp;
		echo "\n\tspeed: " . $this->_speed;
		echo "\n\thandle: " . $this->_handle;
		echo "\n\textra speed: " . $this->_extraSpeed;
		echo "\n\tshield: " . $this->_shield;
		echo "\n\nWeapons: of " . $this->_name . PHP_EOL;

		foreach ($this->_weapons as $key => $weapon) {
			echo PHP_EOL;
			$weapon->display();
			echo PHP_EOL;
		}
	}
}
?>