<?php

namespace CSUNMetaLab\SwordUploader\Exceptions;

class CannotParseDepositResponseException extends DepositException
{
	public function __construct($message="Cannot parse the response from the deposit") {
		parent::__construct($message);
	}
}