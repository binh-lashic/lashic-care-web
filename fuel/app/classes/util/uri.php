<?php

/**
 * Class Util_Uri
 */
class Util_Uri
{
	/**
	 * @param string $query_string
	 * @return array
	 */
	public static function parse_query_string($query_string)
	{
		$parameters = [];
		$key_and_values = explode('&', $query_string);
		foreach ($key_and_values as $key_and_value) {
			if (strstr($key_and_value, '=') === false) {
				continue;
			}
			list($key, $value) = explode('=', $key_and_value);
			if (array_key_exists($key, $parameters)) {
				if (!is_array($parameters[$key])) {
					$parameters[$key] = [$parameters[$key]];
				}
				$parameters[$key][] = $value;
			} else {
				$parameters[$key] = $value;
			}
		}
		return $parameters;
	}

	/**
	 * @param array $parameters
	 * @return string
	 */
	public static function build_query(array $parameters)
	{
		$query = [];

		foreach ($parameters as $key => $value) {

			if (is_array($value)) {
				foreach ($value as $item) {
					$query[] = "{$key}={$item}";
				}
				continue;
			}

			$query[] = "{$key}={$value}";
		}

		return implode('&', $query);
	}
}
