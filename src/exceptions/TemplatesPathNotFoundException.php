<?php
namespace andrewdanilov\exceptions;

class TemplatesPathNotFoundException extends \Exception
{
	public function __construct($path=null)
	{
		$message = 'Templates path not found';
		if ($path) {
			$message .= ': ' . $path;
		}
		parent::__construct($message);
	}
}