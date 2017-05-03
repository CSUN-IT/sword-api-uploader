<?php

namespace CSUNMetaLab\SwordUploader\Exceptions;

use Exception;

class DepositException extends Exception
{
	public function __construct($message="An error occurred during deposit") {
		parent::__construct($message);
	}
}