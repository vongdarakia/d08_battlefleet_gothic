<?php
require_once '../Battlefleet/Battlefleet.class.php';
require_once '../Weapon/Weapon.class.php';

abstract class Spaceship {
	private $_length = 1;
	private $_width = 1;
	private $_hp = 1; // hull/health points
	private $_maxhp = 1; // max hp
	private $_pp = 0; // engine power/power points
	private $_speed = 1; // maximum speed
	private $_handle = 0; // minimum speed
	private $_weapons = array();
	private $_direction = 0; // 0 1 2 3 -> N E S W
	private $_x = 0;
	private $_y = 0;

	private $_shield = 0; // shield
	private $_extraSpeed = 0; // extra speed

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
		if (array_key_exists('x', $kwargs)) {
			$this->_x = $kwargs['x'];
		}
		if (array_key_exists('y', $kwargs)) {
			$this->_y = $kwargs['y'];
		}
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

	// todo: more get functions

	public function spendPP( $speed, $shield, $weapon, $repair ) {
		$pp = $speed + $shield + $repair;
		foreach ($weapon as $amount) {
			$pp += $amount;
		}
		if ($pp > $this->_pp) { 
			// error
			return;
		}
		$this->_extraSpeed = Battlefleet::rollDiceSum($speed);
		$this->_shield = $shield;
		// call weapon stuff
		if (Battlefleet::rollDice($repair)[6] > 0) {
			$this->_hp = $this->_maxhp;
		}
		$this->_speed += $this->_extraSpeed;
	}

	public function resetPP() {
		$this->_speed -= $this->_extraSpeed;
		$this->_extraSpeed = 0;
		$this->_shield = 0;
		// reset weapon stuff
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
}
?>