<?php
require_once '../'

abstract class Spaceship {
	private $_length = 1;
	private $_width = 1;
	private $_hp = 1; // hull/health points
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

	public function spendPP( $speed, $shield, $weapon, $repair ) {
		$this->_shield = $shield;
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