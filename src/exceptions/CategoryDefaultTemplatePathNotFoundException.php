<?php
namespace andrewdanilov\custompages\exceptions;

class CategoryDefaultTemplatePathNotFoundException extends \Exception
{
	public function __construct($path=null)
	{
		$message = 'Not found default template for category in templates path';
		if ($path) {
			$message .= ': ' . $path;
		}
		parent::__construct($message);
	}
}