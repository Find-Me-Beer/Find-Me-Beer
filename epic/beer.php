<?php
namespace ;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Cassandra\Decimal;
use MongoDB\BSON\Binary;
use Ramsey\Uuid\Uuid;

/**
 * Beer class for Find Me Beer Web App
 *
 * This class will hold all the necessary state variables and methods for Beer objects
 *
 * @author Reece Nunn <
 * @version 3.0.0
 **/
class Beer implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this beer; this is the primary key
	 * @var Uuid $beerId
	 */
	private $beerId;
	/**
	 * abv for this beer
	 * @var Decimal $beerAbv
	 */
	private $beerAbv;
	/**
	 * brewery id for this beer; this is the foreign key
	 * @var Binary
	 */

}