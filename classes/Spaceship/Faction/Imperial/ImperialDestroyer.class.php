<?php
require_once './Imperial.class.php';

class ImperialDestroyer extends Imperial {
	public static function doc() {
		return file_get_contents('./ImperialDestroyer.doc.txt');
	}

	public function __construct( $x, $y ) {
		parent::__construct(array('length' => 1, 'width' => 3, 'hp' => 4, 'pp' => 10, 'speed' => 18, 'handle' => 3, 'x' => $x, 'y' => $y));
	}
}
?>