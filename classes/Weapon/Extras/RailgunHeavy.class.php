<?php
require_once 'Weapon.class.php';

class RailgunHeavy extends Weapon {
	public static function doc() {
		return file_get_contents('./RailgunHeavy.doc.txt');
	}

	public function display() {
		echo get_class($this) . PHP_EOL;
		parent::display();
	}

	public function __construct( $owner = null, $ship = null ) {
		parent::__construct(array('charge' => 0, 'short' => 60, 'middle' => 90, 'long' => 120, 'owner' => $owner, 'ship' => $ship));
	}
}
?>