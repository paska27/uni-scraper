<?php
namespace CustomLibrary\PointerBag;

class ReadableBag implements \IteratorAggregate
{
	/**
	 * Initial data.
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Current data when until ->v() is reached.
	 *
	 * @var array
	 */
	protected $pointer;

	/**
	 * @param array $data
	 */
	public function __construct(array $data = array()) {
		$this->data = $data;
		$this->reset();
	}

	/**
	 * @param string $name
	 * @return ReadableBag
	 */
	public function __get($name) {
		if (isset($this->pointer[$name])) {
			$this->pointer = $this->pointer[$name];
		} else {
			$this->pointer  = null;
		}
		return $this;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return (string) $this->v();
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return $this->data;
	}

	/**
	 * @return \ArrayIterator|\Traversable
	 */
	public function getIterator() {
		return new ArrayIterator($this->data);
	}

	/**
	 * @param array $data
	 */
	public function mergeData(array $data) {
		$this->data = array_replace_recursive($this->data, $data);
		$this->reset();
	}

	/**
	 * Resets the pointer to initial data.
	 */
	public function reset() {
		$this->pointer = $this->data;
	}

	/**
	 * Returns the value.
	 *
	 * @return ReadableBag
	 */
	public function v() {
		$v = $this->pointer;
		$this->reset();

		return (is_array($v)) ? new self($v) : $v;
	}
}