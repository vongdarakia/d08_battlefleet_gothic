<?php 
abstract class Object {
	protected $_id;

	public function __construct($id) {
		$this->_id = $id;
	}

	final public function getID() {
		return $this->_id;
	}
}
?>