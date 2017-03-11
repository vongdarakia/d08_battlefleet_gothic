<?php

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

	public function display() {
		echo "\n\tcharge: " . $this->_charge;
		echo "\n\tshort: " . $this->_short;
		echo "\n\tmiddle: " . $this->_middle;
		echo "\n\tlong: " . $this->_long;
	}
}
?>