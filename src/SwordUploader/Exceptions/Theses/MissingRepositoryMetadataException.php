<?php

namespace CSUNMetaLab\SwordUploader\Exceptions\Theses;

use CSUNMetaLab\SwordUploader\Exceptions\CannotCreatePackageException;

class MissingRepositoryMetadataException extends CannotCreatePackageException
{
	public function __construct($message="Thesis metadata for the deposit repository cannot be retrieved") {
		parent::__construct($message);
	}
}