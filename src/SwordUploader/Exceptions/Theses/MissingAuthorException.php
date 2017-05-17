<?php

namespace CSUNMetaLab\SwordUploader\Exceptions\Theses;

use CSUNMetaLab\SwordUploader\Exceptions\CannotCreatePackageException;

class MissingAuthorException extends CannotCreatePackageException
{
	public function __construct($message="Thesis author(s) cannot be retrieved") {
		parent::__construct($message);
	}
}