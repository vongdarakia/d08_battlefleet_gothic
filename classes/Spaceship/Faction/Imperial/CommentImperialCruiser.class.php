<?php
require_once 'Imperial.class.php';
require_once __DIR__ . '/../../../Weapon/LanceBatteryImperial.class.php';

class ImperialCruiser extends Imperial {
	public static function doc() {
		return file_get_contents('./ImperialCruiser.doc.txt');
	}

	public function __construct( $x = 0, $y = 0, $owner = null, $name = 'The Shield of Cherys ) {
		parent::__construct(array('length' => 1, 'width' => 4, 'hp' => 5, 'pp' => 10, 'speed' => 15, 'handle' => 4, 'weapons' => array(new LanceBatteryImperial()), 'cost' => 100, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>