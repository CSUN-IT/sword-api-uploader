<?php

namespace CSUNMetaLab\SwordUploader\Exceptions;

use Exception;

class CannotCreatePackageException extends Exception
{
	public function __construct($message="An error occurred during package creation") {
		parent::__construct($message);
	}
}