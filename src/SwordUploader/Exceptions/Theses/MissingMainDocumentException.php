<?php

namespace CSUNMetaLab\SwordUploader\Exceptions\Theses;

use CSUNMetaLab\SwordUploader\Exceptions\CannotCreatePackageException;

class MissingMainDocumentException extends CannotCreatePackageException
{
	public function __construct($message="The main thesis document is missing") {
		parent::__construct($message);
	}
}