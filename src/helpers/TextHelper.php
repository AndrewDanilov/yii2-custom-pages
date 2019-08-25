<?php
namespace andrewdanilov\custompages\helpers;

class TextHelper
{
	/**
	 * @param $params_string
	 * @return array
	 */
	public static function parseGalleryParams($params_string)
	{
		preg_match_all('/(?:[^\'"\s]+|\'[^\']*\'|"[^"]*")+/', $params_string, $matches);
		$params = array_filter($matches[0]);
		if (empty($params)) {
			return [];
		}
		$params_values = [];
		foreach ($params as $param) {
			list($var, $value) = explode('=', $param);
			$var = trim($var, ' \t\n\r\0\x0B\'"');
			if ($var) {
				$value = trim($value, ' \t\n\r\0\x0B\'"');
				if (empty($value)) {
					$value = '';
				}
				$params_values[$var] = $value;
			}
		}
		return $params_values;
	}

	/**
	 * @param $params array
	 * @param $replaces array
	 * @return array
	 */
	public static function renderGalleryParamsValues($params, $replaces)
	{
		foreach ($params as &$param) {
			$param = strtr($param, $replaces);
		}
		return $params;
	}
}