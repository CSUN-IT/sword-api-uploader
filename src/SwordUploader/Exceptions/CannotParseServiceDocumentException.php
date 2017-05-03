<?php

namespace CSUNMetaLab\SwordUploader\Exceptions;

use Exception;

class CannotParseServiceDocumentException extends Exception
{
	public function __construct($message="Cannot parse the service document") {
		parent::__construct($message);
	}
}