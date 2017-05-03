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
}