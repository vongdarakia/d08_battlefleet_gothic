<?php
require_once 'Weapon.class.php';

class LanceBatteryImperial extends Weapon {
	public static function doc() {
		return file_get_contents('./LanceBatteryImperial.doc.txt');
	}

	public function display() {
		echo get_class($this) . PHP_EOL;
		parent::display();
	}

	public function __construct( $owner = null, $ship = null ) {
		parent::__construct(array('charge' => 0, 'short' => 30, 'middle' => 60, 'long' => 90, 'owner' => $owner, 'ship' => $ship));
	}
}
?>