<?php
namespace Structura\Exceptions;


class InvalidValueException extends StructuraException
{
	public function __construct()
	{
		parent::__construct("Value must be scalar or implement IIdentified");
	}
}