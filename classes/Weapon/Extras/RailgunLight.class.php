<?php
require_once 'Weapon.class.php';

class RailgunLight extends Weapon {
	public static function doc() {
		return file_get_contents('./RailgunLight.doc.txt');
	}

	public function display() {
		echo get_class($this) . PHP_EOL;
		parent::display();
	}

	public function __construct( $owner = null, $ship = null ) {
		parent::__construct(array('charge' => 0, 'short' => 15, 'middle' => 30, 'long' => 45, 'owner' => $owner, 'ship' => $ship));
	}
}
?>