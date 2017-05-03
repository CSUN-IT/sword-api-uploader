<?php

namespace CSUNMetaLab\SwordUploader\Uploaders;

use \SWORDAPPClient;

class SwordUploader
{
	private $service_doc;
	private $deposit;
	private $username;
	private $password;

	private $client;

	public function __construct($service_doc, $deposit, $username, $password) {
		$this->service_doc = $service_doc;
		$this->deposit = $deposit;
		$this->username = $username;
		$this->password = $password;

		$this->client = new SWORDAPPClient();
	}

	/**
	 * Requests and returns the service document based on how this uploader has
	 * been configured via the constructor. This method can also throw an
	 * instance of Exception if the service document cannot be parsed.
	 *
	 * @param string $onBehalfOf Optional string that will set the X-On-Behalf-Of header
	 * @return SWORDAPPServiceDocument
	 *
	 * @throws Exception
	 */
	public function requestServiceDocument($onBehalfOf="") {
		return $this->client->servicedocument(
			$this->service_doc,
			$this->username,
			$this->password,
			$onBehalfOf
		);
	}
}