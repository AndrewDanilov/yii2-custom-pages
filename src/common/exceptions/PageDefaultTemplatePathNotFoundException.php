<?php
namespace andrewdanilov\custompages\common\exceptions;

class PageDefaultTemplatePathNotFoundException extends \Exception
{
	public function __construct($path=null)
	{
		$message = 'Not found default template for page in templates path';
		if ($path) {
			$message .= ': ' . $path;
		}
		parent::__construct($message);
	}
}