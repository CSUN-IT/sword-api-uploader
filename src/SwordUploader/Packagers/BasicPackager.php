<?php

namespace CSUNMetaLab\SwordUploader\Packagers;

use PackagerMetsSwap;
use CSUNMetaLab\SwordUploader\Contracts\PackagerContract;

use Exception;
use CSUNMetaLab\SwordUploader\Exceptions\CannotCreatePackageException;

class BasicPackager extends PackagerMetsSwap implements PackagerContract {

	/**
	 * Constructs a new BasicPackager object.
	 *
	 * @param string $filename The filename that will be used for output
	 */
	public function __construct($filename) {
		parent::__construct(
			config('sword.files.roots.input.root'),
			config('sword.files.roots.input.subdir'),
			config('sword.files.roots.output.package'),
			$filename
		);
	}

	/**
	 * @see CSUNMetaLab\SwordUploader\Contracts\PackagerContract@package
	 */
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