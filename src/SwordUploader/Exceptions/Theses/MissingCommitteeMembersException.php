<?php

namespace CSUNMetaLab\SwordUploader\Exceptions\Theses;

use CSUNMetaLab\SwordUploader\Exceptions\CannotCreatePackageException;

class MissingCommitteeMembersException extends CannotCreatePackageException
{
	public function __construct($message="Thesis committee cannot be retrieved") {
		parent::__construct($message);
	}
}