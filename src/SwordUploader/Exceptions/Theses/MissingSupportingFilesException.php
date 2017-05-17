<?php

namespace CSUNMetaLab\SwordUploader\Exceptions\Theses;

use CSUNMetaLab\SwordUploader\Exceptions\CannotCreatePackageException;

class MissingSupportingFilesException extends CannotCreatePackageException
{
	public function __construct($message="Supporting files for the thesis could not be retrieved") {
		parent::__construct($message);
	}
}