<?php

namespace CSUNMetaLab\SwordUploader\Uploaders;

use SWORDAPPClient;

use Exception;
use SwordHttpException;
use CSUNMetaLab\SwordUploader\Exceptions\CannotParseDepositErrorResponseException;
use CSUNMetaLab\SwordUploader\Exceptions\CannotParseDepositResponseException;
use CSUNMetaLab\SwordUploader\Exceptions\CannotParseServiceDocumentException;
use CSUNMetaLab\SwordUploader\Exceptions\DepositException;

class SwordUploader
{
	private $service_doc;
	private $deposit_id;
	private $username;
	private $password;

	private $client;

	/**
	 * Constructs a new SwordUploader object.
	 *
	 * @param string $service_doc The identifier for the service document
	 * @param string $deposit The identifier for the deposit repository
	 * @param string $username The username that will be used during operations
	 * @param string $password The password that will be used during operations
	 */
	public function __construct($service_doc, $deposit, $username, $password) {
		$this->service_doc = $service_doc;
		$this->deposit_id = $deposit;
		$this->username = $username;
		$this->password = $password;

		$this->client = new SWORDAPPClient();
	}

	/**
	 * Deposits the specified file into the repository that was been configured
	 * upon instantiation. Returns an instance of SWORDAPPEntry on success or
	 * SWORDAPPErrorDocument on failure; please keep in mind that SWORDAPPErrorDocument
	 * is a subclass of SWORDAPPEntry if you do an instanceof check.
	 *
	 * This method can also throw the following exceptions:
	 * CannotParseDepositResponseException if the success response could not be parsed
	 * CannotParseDepositErrorResponseException if the error response could not be parsed
	 * DepositException if a general deposit error happens
	 *
	 * @param string $filename The path to the file to deposit
	 * @param string $onBehalfOf Optional string to set the X-On-Behalf-Of header
	 * @param string $packaging Optional string to set the X-Packaging header
	 * @param string $contentType Optional string to set the Content-Type header
	 * @param boolean $noOp Optionally set X-No-Op header; defaults to false
	 * @param boolean $verbose Optionally set X-Verbose header; defaults to false
	 *
	 * @return SWORDAPPEntry|SWORDAPPErrorDocument
	 *
	 * @throws CannotParseDepositResponseException
	 * @throws CannotParseDepositErrorResponseException
	 * @throws DepositException
	 */
	public function deposit($filename, $onBehalfOf="", $packaging="", $contentType="",
		$noOp=false, $verbose=false) {
		try {
			return $this->client->deposit(
				$this->deposit_id,
				$this->username,
				$this->password,
				$onBehalfOf,
				$filename,
				$packaging,
				$contentType,
				$noOp,
				$verbose
			);
		}
		catch(SwordHttpException $e) {
			if(stripos($e->getMessage(), "response entry") !== FALSE) {
				// the upload was successful but the response was not parseable
				throw new CannotParseDepositResponseException($e->getMessage());
			}
			elseif(stripos($e->getMessage(), "error document") !== FALSE) {
				// the upload failed and the error document could not be parsed
				throw new CannotParseDepositErrorResponseException($e->getMessage());
			}
		}
		catch(Exception $e) {
			// some other kind of exception occurred
			throw new DepositException($e->getMessage());
		}
	}

	/**
	 * Deposits the specified file into the repository that was been configured
	 * upon instantiation. This method uses the default configuration parameters
	 * in order to describe the deposit behavior.
	 *
	 * All other functionality of this method matches the deposit() method.
	 *
	 * @param string $filename The path to the file to deposit
	 *
	 * @return SWORDAPPEntry|SWORDAPPErrorDocument
	 *
	 * @throws CannotParseDepositResponseException
	 * @throws CannotParseDepositErrorResponseException
	 * @throws DepositException
	 *
	 * @see CSUNMetaLab\SwordUploader\Uploaders\SwordUploader@deposit
	 */
	public function depositDefault($filename) {
		return $this->deposit(
			$filename,
			config('sword.behavior.onBehalfOf'),
			config('sword.behavior.packaging'),
			config('sword.behavior.contentType'),
			config('sword.behavior.noOp'),
			config('sword.behavior.verbose')
		);
	}

	/**
	 * Requests and returns the service document based on how this uploader has
	 * been configured via the constructor. This method can also throw an
	 * instance of CannotParseServiceDocumentException if the service document
	 * cannot be parsed.
	 *
	 * @param string $onBehalfOf Optional string that will set the X-On-Behalf-Of header
	 * @return SWORDAPPServiceDocument
	 *
	 * @throws CannotParseServiceDocumentException
	 */
	public function requestServiceDocument($onBehalfOf="") {
		try {
			return $this->client->servicedocument(
				$this->service_doc,
				$this->username,
				$this->password,
				$onBehalfOf
			);
		}
		catch(Exception $e) {
			throw new CannotParseServiceDocumentException($e->getMessage());
		}
	}
}