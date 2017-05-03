<?php

namespace CSUNMetaLab\SwordUploader\Contracts;

interface PackagerContract
{
	/**
	 * Creates and packages the file containing all necessary files and the METS file.
	 * Throws CannotCreatePackageException if the package could not be created.
	 *
	 * @throws CannotCreatePackageException
	 */
	public function package();
}