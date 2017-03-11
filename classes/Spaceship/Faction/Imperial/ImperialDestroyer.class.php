<?php
require_once 'Imperial.class.php';
require_once __DIR__ . '/../../../Weapon/NauticalLance.class.php';

class ImperialDestroyer extends Imperial {
	public static function doc() {
		return file_get_contents('./ImperialDestroyer.doc.txt');
	}

	public function __construct( $owner, $x, $y, $name = 'Imperial Destroyer' ) {
		parent::__construct(array('length' => 1, 'width' => 3, 'hp' => 4, 'pp' => 10, 'speed' => 18, 'handle' => 3, 'weapons' => array(new NauticalLance()), 'cost' => 100, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>