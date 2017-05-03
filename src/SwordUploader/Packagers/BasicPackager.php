<?php

namespace CSUNMetaLab\SwordUploader\Packagers;

use PackagerMetsSwap;
use CSUNMetaLab\SwordUploader\Contracts\PackagerContract;

use Exception;
use CSUNMetaLab\SwordUploader\Exceptions\CannotCreatePackageException;

class BasicPackager extends PackagerMetsSwap implements PackagerContract {
	public function package() {
		try {
			// attempt to create the package by leveraging the parent class
			$this->create();
		}
		catch(Exception $e) {
			throw new CannotCreatePackageException($e->getMessage());
		}
	}
}