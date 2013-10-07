<?php
namespace CustomLibrary;

/**
 * Object-oriented array interface
 * Usage example:
 * xArray::from(array('wdwedwe'=>234,'qws'=>3342,'xxxx'=>45,'34rf'=>'vv','3e3e'=>45))
 *      ->unique()
 *      ->map(function($a){return '-'.$a.'-';})
 *      ->asort()
 *      ->print_r();
 * 
 * @copyright (c) 2013, Alexey Kulentsov (crimaniak).
 */

class XArray implements \ArrayAccess, \IteratorAggregate
{
	protected static $notFirst = array
		('array_map'    => 1
		,'array_search' => 1
		,'in_array'     => 1
	);
	
	protected static $returnPlain = array
		('each'
		,'current'
		,'end'
		,'splice'
	);
	
	protected static $returnSelf = array
		('sort'
		,'asort'
		,'arsort'
		,'ksort'
		,'rsort'
		,'uasort'
		,'uksort'
		,'usort'
		,'multisort'
		,'array_walk'
	);

	protected $array;
	
	/**
	 * @param array $array
	 * @return XArray
	 */
	public static function from($array = array()) {
		return new self($array);
	}

	public function __construct(array $array = array()) {
		switch(gettype($array)) {
			case 'array':
				$this->array = $array; 
				break;
			case 'object':
				$this->array = is_a($array, __CLASS__) ? $array->array : get_object_vars($array);
				break;
			case 'NULL':
				$this->array = array();
				break;
			default:
				throw new \Exception("xArray can't be constructed from " . gettype($array));
		}
	}

	/**
	 * @param string $method
	 * @param type $args
	 * 
	 * @return XArray
	 * 
	 * @throws Exception
	 */
	public function __call($method, $args) {
		if (function_exists('array_' . $method))
			$method = 'array_' . $method;
		else if (!function_exists($method))
			throw new Exception("Unknown method xArray::$method");

		array_splice($args, isset(self::$notFirst[$method]) ? self::$notFirst[$method] : 0, 0, array(&$this->array));
		$result = call_user_func_array($method, $args);

		return in_array($method, self::$returnSelf) ? $this : (is_array($result)&&!in_array($method, self::$returnPlain) ? new self($result) : $result);
	}
	
	public function offsetExists($index) { return array_key_exists($index, $this->array); }
	public function offsetGet($index) { return $this->array[$index]; }
	public function offsetSet($index, $newval) { $this->array[$index] = $newval; }
	public function offsetUnset($index) { unset($this->array[$index]); }

	public function getIterator() { return new ArrayIterator($this->array); }

	/**
	 * @param callback $fn
	 * @param mixed $data
	 * 
	 * @return XArray
	 */
	public function keymap($fn, $data = null) {
		$result = array();
		foreach($this->array as $key => $value) {
			$result[$fn($value, $key, $data)] = $value;
		}
		return self::from($result);
	}

	/**
	 * @param callback $fn
	 * @param mixed $data
	 
	 * @return XArray
	 */
	public function mapk($fn, $data = null) {
		$result = array();
		foreach($this->array as $key => $value) {
			$result[$key] = $fn($value, $key, $data);
		}
		return self::from($result);
	}

	/**
	 * @return array $array
	 */
	public function toArray() {
		return $this->array;
	}

	/**
	 * Unify list of strings with optional additional parameters given in the case of key => value form.
	 * Example:
	 * [ 'item1', 'item2' => array('parameters'), 'item3' ] -> unifyOptional()
	 * will give
	 * [ 'item1' => null, 'item2' => array('parameters'), 'item3' => null ]
	 *
	 * @return XArray
	 */
	public function unifyOptional() {
		$result = array();
		foreach($this->array as $key => $value) {
			if(is_string($key)) {
				$result[$key] = $value;
			} elseif (is_array($value)) {
				$result = array_merge($result, $value);
			} else {
				$result[$value] = null;
			}
		}
		return self::from($result);
	}

}