<?php
namespace CustomLibrary;

class PointerBag
{
	protected $data;
	
	protected $pointer;
	
	public function getData() {
		return $this->data;
	}

	public function __construct(array $data = array()) {
		$this->data = $data;
		$this->reset();
	}
	
	public function __get($name) {
		if (isset($this->pointer[$name])) {
			$this->pointer = $this->pointer[$name];
		} else {
			$this->pointer  = null;
		}
		return $this;
	}
	
	public function __toString() {
		$v = (string) $this->v();
		$this->reset();
		
		return $v;
	}
	
	public function mergeData(array $data) {
		$this->data = array_merge_recursive($this->data, $data);
		$this->reset();
	}
	
	public function reset() {
		$this->pointer = $this->data;
	}
	
	public function v() {
		$v = $this->pointer;
		$this->reset();
		
		return $v;
	}
}