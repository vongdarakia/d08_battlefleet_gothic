<?php
require_once 'Imperial.class.php';
require_once __DIR__ . '/../../../Weapon/NauticalLance.class.php';

class ImperialFrigate extends Imperial {
	public static function doc() {
		return file_get_contents('./ImperialFrigate.doc.txt');
	}

	public function __construct( $owner = null, $x = 0, $y = 0, $name = 'Imperial Frigate' ) {
		parent::__construct(array('length' => 1, 'width' => 4, 'hp' => 5, 'pp' => 10, 'speed' => 15, 'handle' => 4, 'weapons' => array(new NauticalLance()), 'cost' => 100, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>