<?php

namespace CSUNMetaLab\SwordUploader\Exceptions;

class CannotParseDepositErrorResponseException extends CannotParseDepositResponseException
{
	public function __construct($message="Cannot parse the error response from the deposit") {
		parent::__construct($message);
	}
}