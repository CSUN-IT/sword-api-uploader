<?php

namespace CSUNMetaLab\SwordUploader\Exceptions\Theses;

use CSUNMetaLab\SwordUploader\Exceptions\CannotCreatePackageException;

class MissingDegreePlanException extends CannotCreatePackageException
{
	public function __construct($message="Thesis degree plan cannot be retrieved") {
		parent::__construct($message);
	}
}