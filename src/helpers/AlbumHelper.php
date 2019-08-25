<?php
namespace andrewdanilov\custompages\helpers;

class AlbumHelper
{
	/**
	 * @param $shortcode_name string
	 * @param $text string
	 * @param $albums array
	 * @return array
	 */
	public static function parseShortcodes($shortcode_name, $text, $albums)
	{
		$_albums = [];
		if (strpos($text, '[' . $shortcode_name) !== false) {
			preg_match_all('/(?:<p>)?\[(\w+)\s+([\w\d]+)(?:\s+(.+))?\](?:<\/p>)?/ui', $text, $matches, PREG_SET_ORDER);
			foreach ($matches as $match) {
				if ($shortcode_name === $match[0]) {
					$shortcode = $match[1];
					$album_id = $match[2];
					$params = static::parseShortcodeParams($match[3]);
					$_albums[] = [
						'id' => $album_id,
						'shortcode' => $shortcode,
						'params' => $params,
						'photos' => static::applyParamsToPhotos($albums[$album_id], $params),
					];
				}
			}
		}
		return $_albums;
	}

	/**
	 * @param $params_string string
	 * @return array
	 */
	public static function parseShortcodeParams($params_string)
	{
		preg_match_all('/(?:[^\'"\s]+|\'[^\']*\'|"[^"]*")+/', $params_string, $matches);
		$params = array_filter($matches[0]);
		if (empty($params)) {
			return [];
		}
		$_params = [];
		foreach ($params as $param) {
			list($var, $value) = explode('=', $param);
			$var = trim($var, ' \t\n\r\0\x0B\'"');
			if ($var) {
				$_params[$var] = trim($value, ' \t\n\r\0\x0B\'"');
			}
		}
		return $_params;
	}

	/**
	 * @param $images array
	 * @param $params array
	 * @return array
	 */
	public static function applyParamsToPhotos($images, $params)
	{
		$photos = [];
		foreach ($images as $index => $image) {
			$replaces = [
				'{index}' => $index,
				'{filename}' => pathinfo($image, PATHINFO_FILENAME),
				'{basename}' => pathinfo($image, PATHINFO_BASENAME),
				'{extension}' => pathinfo($image, PATHINFO_EXTENSION),
			];
			$photos[] = [
				'image' => $image,
				'alt' => strtr($params['alt'], $replaces),
			];
		}
		return $photos;
	}
}