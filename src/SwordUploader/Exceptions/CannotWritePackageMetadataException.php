<?php

namespace CSUNMetaLab\SwordUploader\Exceptions;

class CannotWritePackageMetadataException extends CannotCreatePackageException
{
	public function __construct($message="Cannot open metadata file for writing") {
		parent::__construct($message);
	}
}