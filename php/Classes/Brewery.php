<?php

namespace Celeste3\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Class Brewery
 * @Author Celeste Whitaker <cwhitaker4@cnm,edu>
 */

class Brewery implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id for this Brewery; this is the primary key
	 * @var Uuid $breweryId
	 */

	private $breweryId;

	private $breweryAddress;

	private $breweryAvatarUrl;

	private $breweryDescription;

	private $breweryEmail;

	private $breweryName;

	private $breweryLat;

	private $breweryLong;

	private $breweryPhone;

	private $breweryUrl;

	public function __construct ($breweryId, $breweryAddress, $breweryAvatarUrl, $breweryDescription, $breweryEmail, $breweryLat, $breweryLong, $breweryName, $breweryPhone,$breweryUrl) {
		try {
			$this->breweryId($breweryId)
			$this->breweryAddress($breweryAddress);
			$this->breweryAvatarUrl(breweryAvatarUrl);
			$this->breweryDescription

		}

	}
}

?>





