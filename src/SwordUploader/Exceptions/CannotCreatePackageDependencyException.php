<?php

namespace CSUNMetaLab\SwordUploader\Exceptions;

class CannotCreatePackageDependencyException extends CannotCreatePackageException
{
	public function __construct($message="A package creation dependency is missing") {
		parent::__construct($message);
	}
}