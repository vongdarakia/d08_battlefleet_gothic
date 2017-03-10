<?php
require_once './Imperial.class.php';

class ImperialFrigate extends Imperial {
	public static function doc() {
		return file_get_contents('./ImperialFrigate.doc.txt');
	}

	public function __construct( $x, $y ) {
		parent::__construct(array('length' => 1, 'width' => 4, 'hp' => 5, 'pp' => 10, 'speed' => 15, 'handle' => 4, 'x' => $x, 'y' => $y));
	}
}
?>