<?php

abstract class Spaceship {
	private $_length = 1; // length of Spaceship
	private $_width = 1; // width of Spaceship
	private $_hp = 1; // hull/health points
	private $_pp = 0; // engine power/power points
	private $_speed = 1; // speed
	private $_handle = 0; // handling
	private $_shield = 0; // shield
	private $_weapons = array(); // weapons
	private $_direction = 0; // direction (0 1 2 3 -> N E S W)

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

	public function takeDamage( $d ) {
		if ($d <= $this->_shield) {
			$this->_shield -= $d;
		}
		else {
			$this->_hp += $this->_shield;
			$this->_hp -= $d;
		}
	}

	public function isDead() {
		return $this->_hp <= 0;
	}
}
?>