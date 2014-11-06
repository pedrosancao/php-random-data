<?php

/**
 * @author   Pedro Sanção <pedro at sancao dot co>
 * @license  MIT, see LICENCE.
 * @version  Beta
 */
class Random {

	/**
	 * Read bytes from /dev/urandom
	 * 
	 * @param int $length Amount of bytes that should be read
	 * @return boolean|string A string of binary data read from /dev/urandom
	 * or false on errors
	 */
	protected static function getRandomBytes($length) {
		try {
			$handle = fopen('/dev/urandom', 'rb');
			if ($handle !== false) {
				$read = fread($handle, $length);
				fclose($handle);
				return $read;
			}
		} catch (Exception $e) {
		}
		return false;
	}

	/**
	 * Generate random data based on the provided parameters
	 * 
	 * @param int $length Amount of characters of generated data
	 * @param int $packSize Amount of bytes for unpack function
	 * @param string $packFormat Definition of format for unpack function
	 * @param callable $callback a function to manipulated unpacked value
	 * @return boolean|string The generated string
	 */
	protected static function getRandomData($length, $packSize, $packFormat, $callback = null) {
		$data = '';
		while(strlen($data) < $length) {
			$randomBytes = self::getRandomBytes($packSize);
			if ($randomBytes === false) {
				return false;
			}
			$value = unpack($packFormat, $randomBytes)[1];
			if (is_callable($callback)) {
				$value = call_user_func($callback, $value);
			}
			$data .= $value;
		}
		return substr($data, 0, $length);
	}

	/**
	 * Generate a random integer
	 * 
	 * @param int $length
	 * @return string The string representation of generated integer
	 */
	public static function integer($length) {
		return self::getRandomData($length, 4, 'I', 'self::integerCallback');
	}

	/**
	 * Remove digits that don't reache the 0-9 range and zero fill to 9 digits
	 * 
	 * @param string $value
	 * @return string processed value
	 */
	private static function integerCallback($value) {
		return str_pad(substr($value, -9), 9, 0, STR_PAD_LEFT);
	}

	/**
	 * Generate a random hexadecimal
	 * 
	 * @param int $length
	 * @return string The string representation of generated hexadecimal
	 */
	public static function hex($length) {
		return self::getRandomData($length, ceil($length / 2), 'h*');
	}

}
