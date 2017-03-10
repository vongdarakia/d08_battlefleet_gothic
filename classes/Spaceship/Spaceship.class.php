<?php

abstract class Spaceship {
	public $length = 1; // length of Spaceship
	public $width = 1; // width of Spaceship
	public $hp = 1; // hull/health points
	public $pp = 0; // engine power/power points
	public $speed = 1; // speed
	public $handle = 0; // handling
	public $shield = 0; // shield
	public $weapons = array(); // weapons
	public $direction = 0; // direction (0 1 2 3 -> N E S W)

	public static function doc() {
		return file_get_contents('./Spaceship.doc.txt');
	}

	public function __construct( array $kwargs ) {
		if (array_key_exists('length', $kwargs)) {
			$this->length = $kwargs['length'];
		}
		if (array_key_exists('width', $kwargs)) {
			$this->width = $kwargs['width'];
		}
		if (array_key_exists('hp', $kwargs)) {
			$this->hp = $kwargs['hp'];
		}
		if (array_key_exists('pp', $kwargs)) {
			$this->pp = $kwargs['pp'];
		}
		if (array_key_exists('speed', $kwargs)) {
			$this->speed = $kwargs['speed'];
		}
		if (array_key_exists('handle', $kwargs)) {
			$this->handle = $kwargs['handle'];
		}
		if (array_key_exists('shield', $kwargs)) {
			$this->shield = $kwargs['shield'];
		}
		if (array_key_exists('weapons', $kwargs)) {
			$this->weapons = $kwargs['weapons'];
		}
		if (array_key_exists('direction', $kwargs)) {
			$this->direction = $kwargs['direction'];
		}
	}
}
?>