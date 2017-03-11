<?php
require_once __DIR__ . '/../../Spaceship.class.php';

class Imperial extends Spaceship {
	public static function doc() {
		return file_get_contents('./Imperial.doc.txt');
	}

	public function __construct( array $kwargs ) {
		parent::__construct($kwargs);
	}
}
?>