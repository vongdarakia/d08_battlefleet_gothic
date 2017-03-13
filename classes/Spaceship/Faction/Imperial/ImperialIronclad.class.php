<?php
require_once 'Imperial.class.php';
require_once __DIR__ . '/../../../Weapon/HeavyNauticalLance.class.php';

class ImperialFrigate extends Imperial {
	public static function doc() {
		return file_get_contents('./ImperialIronclad.doc.txt');
	}

	public function __construct( $x = 0, $y = 0, $owner = null, $name = 'Imperial Ironclad' ) {
		parent::__construct(array('length' => 2, 'width' => 7, 'hp' => 10, 'pp' => 12, 'speed' => 10, 'handle' => 5, 'weapons' => array(new HeavyNauticalLance($this)), 'cost' => 500, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>