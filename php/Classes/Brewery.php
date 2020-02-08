<?php

namespace Celeste3\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Brewery implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
/**
 * Class Brewery
 * @Author Celeste Whitaker <cwhitaker4@cnm,edu>
 */

	use ValidateUuid;

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

}







