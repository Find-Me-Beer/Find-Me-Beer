<?php

namespace FindMeBeer\FindMeBeer\Test;
use FindMeBeer\FindMeBeer\{Brewery};

// grab the class under scrutiny
require_once ("FindMeBeerTest.php");
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Brewery class
 *
 * This is a complete PHPUnit test of the Brewery class. It is complete because *ALL* mySQL/PDO enabled methods
 *
 * @see Brewery
 * @author Celeste Whitaker <cwhitaker4@cnm.edu>
 * @modeled after DataDesign.php by Dylan McDonald <dmcdonald21@cnm.edu>
 **/

class BreweryTest extends FindMeBeerTest {
	/**
	 * @var int VALID_BREWERY_ID
	 */
	protected $VALID_BREWERY_ID = null;

	/**
	 * address of brewery
	 * @var string $VALID_BREWERY_ADDRESS
	 */
	protected $VALID_BREWERY_ADDRESS = "2316 56th st";

	/**
	 * @var string $VALID_BREWERY_AVATAR_URL
	 */
	protected $VALID_BREWERY_AVATAR_URL = "https://gravatar.com/avatar/60d845492a4bb0fa50049511ec139ce8?s=400&d=robohash&r=x";

	/**
	 * Description of Brewery
	 * @var string $VALID_BREWERY_DESCRIPTION
	 */
	protected $VALID_BREWERY_DESCRIPTION = "Founded in 2008 in the heart of downtown Albuquerque, Marble Brewery is devoted to brewing premium craft beer that satisfies the thirsts and discriminating tastes of our diverse and loyal customers. Not only do we brew quality craft beer classics, our fresh cutting-edge specials relentlessly push boundaries and raise expectations.";

	/**
	 * To test brewery description
	 * @var string
	 */
	protected $VALID_BREWERY_DESCRIPTION2 = "Brewery Description Test2";

	/**
	 * Email for brewery
	 * @var string $VALID_BREWERY_EMAIL
	 */
	protected $VALID_BREWERY_EMAIL = "brewery@gmail.com";

	/**
	 * Testing Brewery Email
	 * @var string $VALID_BREWERY_EMAIL2
	 */
	protected $VALID_BREWERY_EMAIL2 = "brewery2@gmail.com";

	/**
	 * Brewery name
	 * @var string $VALID_BREWERY_NAME
	 */
	protected $VALID_BREWERY_NAME = "Marble Brewery";

	/**
	 * Brewery Latitude
	 * @var string
	 */
	protected $VALID_BREWERY_LAT = 35.084251;

	/**
	 * Brewery Longitude
	 * @var string $VALID_BREWERY_LONG
	 */
	protected $VALID_BREWERY_LONG = -106.649239;

	/**
	 * Brewery Phone Number
	 * @var string $VALID_BREWERY_PHONE
	 */
	protected $VALID_BREWERY_PHONE = "(505)337-3333";

	/**
	 * Brewery URL
	 * @var string $VALID_BREWERY_URL
	 */
	protected $VALID_BREWERY_URL = "https://marblebrewery.com/";

	/**
	 * create dependent objects before running each test
	 */
	protected final function setUp(): void {
		//run the default setUp() method
		parent::setUp();

	}

	/**
	 * test inserting a valid Brewery and verify that the actual mySQL data matches
	 **/
	public function testInsertValidBrewery(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("brewery");

		$breweryId = generateUuidV4();

		$brewery = new Brewery ($breweryId,
			$this->VALID_BREWERY_ADDRESS,
			$this->VALID_BREWERY_AVATAR_URL,
			$this->VALID_BREWERY_DESCRIPTION,
			$this->VALID_BREWERY_EMAIL,
			$this->VALID_BREWERY_NAME,
			$this->VALID_BREWERY_LAT,
			$this->VALID_BREWERY_LONG,
			$this->VALID_BREWERY_PHONE,
			$this->VALID_BREWERY_URL);
		$breweryId = ($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoBrewery = Brewery::getBreweryByBreweryId($this->getPDO(), $brewery->getBreweryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("brewery"));
		//$this->assertEquals($pdoBrewery->getBreweryId(), $breweryId);
		$this->assertEquals($pdoBrewery->getBreweryAddress(), $this->VALID_BREWERY_ADDRESS);
		$this->assertEquals($pdoBrewery->getBreweryAvatarUrl(), $this->VALID_BREWERY_AVATAR_URL);
		$this->assertEquals($pdoBrewery->getBreweryDescription(), $this->VALID_BREWERY_DESCRIPTION);
		$this->assertEquals($pdoBrewery->getBreweryEmail(), $this->VALID_BREWERY_EMAIL);
		$this->assertEquals($pdoBrewery->getBreweryName(), $this->VALID_BREWERY_NAME);
		$this->assertEquals($pdoBrewery->getBreweryLat(), $this->VALID_BREWERY_LAT);
		$this->assertEquals($pdoBrewery->getBreweryLong(), $this->VALID_BREWERY_LONG);
		$this->assertEquals($pdoBrewery->getBreweryPhone(), $this->VALID_BREWERY_PHONE);
		$this->assertEquals($pdoBrewery->getBreweryUrl(), $this->VALID_BREWERY_URL);
	}

	/**
	 * test inserting Brewery, editing it, and then updating it
	 */
	public function testUpdateValidBrewery() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("brewery");

		// create a new Brewery and insert to into mySQL
		$breweryId = generateUuidV4();
		$brewery = new Brewery($breweryId,
			$this->VALID_BREWERY_ADDRESS,
			$this->VALID_BREWERY_AVATAR_URL,
			$this->VALID_BREWERY_DESCRIPTION,
			$this->VALID_BREWERY_EMAIL,
			$this->VALID_BREWERY_NAME,
			$this->VALID_BREWERY_LAT,
			$this->VALID_BREWERY_LONG,
			$this->VALID_BREWERY_PHONE,
			$this->VALID_BREWERY_URL);
		$brewery->insert($this->getPDO());

		// edit the Brewery and update it in mySQL
		$brewery->setBreweryDescription($this->VALID_BREWERY_DESCRIPTION2);
		$brewery->update($this->getPDO());

		// set the data from mySQL and enforce the fields match our expectations
		$pdoBrewery = Brewery::getBreweryByBreweryId($this->getPDO(), $brewery->getBreweryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("brewery"));
		$this->assertEquals($pdoBrewery->getBreweryId(), $breweryId);
		$this->assertEquals($pdoBrewery->getBreweryAddress(), $this->VALID_BREWERY_ADDRESS);
		$this->assertEquals($pdoBrewery->getBreweryAvatarUrl(), $this->VALID_BREWERY_AVATAR_URL);
		$this->assertEquals($pdoBrewery->getBreweryDescription(), $this->VALID_BREWERY_DESCRIPTION2);
		$this->assertEquals($pdoBrewery->getBreweryEmail(), $this->VALID_BREWERY_EMAIL);
		$this->assertEquals($pdoBrewery->getBreweryName(), $this->VALID_BREWERY_NAME);
		$this->assertEquals($pdoBrewery->getBreweryLat(), $this->VALID_BREWERY_LAT);
		$this->assertEquals($pdoBrewery->getBreweryLong(), $this->VALID_BREWERY_LONG);
		$this->assertEquals($pdoBrewery->getBreweryPhone(), $this->VALID_BREWERY_PHONE);
		$this->assertEquals($pdoBrewery->getBreweryUrl(), $this->VALID_BREWERY_URL);
	}

	/**
	 * testing delete Brewery
	 */
	public function testDeleteValidBrewery() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("brewery");

		// create a new Brewery and insert to into mySQL
		$breweryId = generateUuidV4();
		$brewery = new Brewery($breweryId,
			$this->VALID_BREWERY_ADDRESS,
			$this->VALID_BREWERY_AVATAR_URL,
			$this->VALID_BREWERY_DESCRIPTION,
			$this->VALID_BREWERY_EMAIL,
			$this->VALID_BREWERY_NAME,
			$this->VALID_BREWERY_LAT,
			$this->VALID_BREWERY_LONG,
			$this->VALID_BREWERY_PHONE,
			$this->VALID_BREWERY_URL);
		$brewery->insert($this->getPDO());

		/// delete the Brewery from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("brewery"));
		$brewery->delete($this->getPDO());

		// grab the Brewery from mySQL and enforce that the Brewery does not exist
		$pdoBrewery = Brewery::getBreweryByBreweryId($this->getPDO(), $brewery->getBreweryId());
		$this->asserNull($pdoBrewery);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("brewery"));

	}

	/**
	 * test getting Brewery by Brewery
	 */
	public function testGetAllValidBreweries() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("brewery");

		// create a new Brewery and insert to into mySQL
		$breweryId = generateUuidV4();
		$brewery = new Brewery($breweryId,
			$this->VALID_BREWERY_ADDRESS,
			$this->VALID_BREWERY_AVATAR_URL,
			$this->VALID_BREWERY_DESCRIPTION,
			$this->VALID_BREWERY_EMAIL,
			$this->VALID_BREWERY_NAME,
			$this->VALID_BREWERY_LAT,
			$this->VALID_BREWERY_LONG,
			$this->VALID_BREWERY_PHONE,
			$this->VALID_BREWERY_URL);
		$brewery->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Brewery::getAllBreweries($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("brewery"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FindMeBeer\\FindMeBeer\\Beer", $results);

		// grab the result from the array and validate it
		$pdoBrewery = $results[0];

		$this->assertEquals($pdoBrewery->getBreweryId(), $breweryId);
		$this->assertEquals($pdoBrewery->getBreweryId(), $this->brewery->getBreweryId());
		$this->assertEquals($pdoBrewery->getBreweryAddress(), $this->VALID_BREWERY_ADDRESS);
		$this->assertEquals($pdoBrewery->getBreweryAvatarUrl(), $this->VALID_BREWERY_AVATAR_URL);
		$this->assertEquals($pdoBrewery->getBreweryDescription(), $this->VALID_BREWERY_DESCRIPTION);
		$this->assertEquals($pdoBrewery->getBreweryEmail(), $this->VALID_BREWERY_EMAIL);
		$this->assertEquals($pdoBrewery->getBreweryName(), $this->VALID_BREWERY_NAME);
		$this->assertEquals($pdoBrewery->getBreweryLat(), $this->VALID_BREWERY_LAT);
		$this->assertEquals($pdoBrewery->getBreweryLong(), $this->VALID_BREWERY_LONG);
		$this->assertEquals($pdoBrewery->getBreweryPhone(), $this->VALID_BREWERY_PHONE);
		$this->assertEquals($pdoBrewery->getBreweryUrl(), $this->VALID_BREWERY_URL);

	}

/**
 * test inserting a Brewery and regrabbing it from mySQL
 **/
public function testGetBreweryByBreweryId() {
	// count number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("brewery");

	// create a new Brewery and insert to into mySQL
	$breweryId = generateUuidV4();
	$brewery = new Brewery($breweryId,
		$this->brewery->getBreweryId(),
		$this->VALID_BREWERY_ADDRESS,
		$this->VALID_BREWERY_AVATAR_URL,
		$this->VALID_BREWERY_DESCRIPTION,
		$this->VALID_BREWERY_EMAIL,
		$this->VALID_BREWERY_NAME,
		$this->VALID_BREWERY_LAT,
		$this->VALID_BREWERY_LONG,
		$this->VALID_BREWERY_PHONE,
		$this->VALID_BREWERY_URL);
		$brewery->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Brewery::getBreweryByBreweryId($this->getPDO(), $this->getBreweryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("brewery"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FindMeBeer\\FindMeBeer\\Beer", $results);

		//get the result from the array and validate it
		$pdoBrewery = $results[0];

		$this->assertEquals($pdoBrewery->getBreweryId(), $breweryId);
		$this->assertEquals($pdoBrewery->getBreweryId(), $this->brewery->getBreweryId());
		$this->assertEquals($pdoBrewery->getBreweryAddress(), $this->VALID_BREWERY_ADDRESS);
		$this->assertEquals($pdoBrewery->getBreweryAvatarUrl(), $this->VALID_BREWERY_AVATAR_URL);
		$this->assertEquals($pdoBrewery->getBreweryDescription(), $this->VALID_BREWERY_DESCRIPTION);
		$this->assertEquals($pdoBrewery->getBreweryEmail(), $this->VALID_BREWERY_EMAIL);
		$this->assertEquals($pdoBrewery->getBreweryName(), $this->VALID_BREWERY_NAME);
		$this->assertEquals($pdoBrewery->getBreweryLat(), $this->VALID_BREWERY_LAT);
		$this->assertEquals($pdoBrewery->getBreweryLong(), $this->VALID_BREWERY_LONG);
		$this->assertEquals($pdoBrewery->getBreweryPhone(), $this->VALID_BREWERY_PHONE);
		$this->assertEquals($pdoBrewery->getBreweryUrl(), $this->VALID_BREWERY_URL);

}

/**
 * test getting Brewery by Brewery
 */
public function testGetValidBreweryByBreweryName() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("brewery");

	// create a new Brewery and insert to into mySQL
	$breweryId = generateUuidV4();
	$brewery = new Brewery($breweryId->$this->brewery->getBreweryName(),
		$this->VALID_BREWERY_ADDRESS,
		$this->VALID_BREWERY_AVATAR_URL,
		$this->VALID_BREWERY_DESCRIPTION,
		$this->VALID_BREWERY_EMAIL,
		$this->VALID_BREWERY_NAME,
		$this->VALID_BREWERY_LAT,
		$this->VALID_BREWERY_LONG,
		$this->VALID_BREWERY_PHONE,
		$this->VALID_BREWERY_URL);
	$brewery->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields match our expectations
	$results = Brewery::GetValidBreweryByBreweryName($this->getPDO(), $this->getBreweryName());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("brewery"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("FindMeBeer\\FindMeBeer\\Beer", $results);

	//get the result from the array and validate it
	$pdoBrewery = $results[0];

	$this->assertEquals($pdoBrewery->getBreweryId(), $breweryId);
	$this->assertEquals($pdoBrewery->getBreweryId(), $this->brewery->getBreweryId());
	$this->assertEquals($pdoBrewery->getBreweryAddress(), $this->VALID_BREWERY_ADDRESS);
	$this->assertEquals($pdoBrewery->getBreweryAvatarUrl(), $this->VALID_BREWERY_AVATAR_URL);
	$this->assertEquals($pdoBrewery->getBreweryDescription(), $this->VALID_BREWERY_DESCRIPTION);
	$this->assertEquals($pdoBrewery->getBreweryEmail(), $this->VALID_BREWERY_EMAIL);
	$this->assertEquals($pdoBrewery->getBreweryName(), $this->VALID_BREWERY_NAME);
	$this->assertEquals($pdoBrewery->getBreweryLat(), $this->VALID_BREWERY_LAT);
	$this->assertEquals($pdoBrewery->getBreweryLong(), $this->VALID_BREWERY_LONG);
	$this->assertEquals($pdoBrewery->getBreweryPhone(), $this->VALID_BREWERY_PHONE);
	$this->assertEquals($pdoBrewery->getBreweryUrl(), $this->VALID_BREWERY_URL);

}

public function testGetValidBreweryByBreweryLocation() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("brewery");

	// create a new Brewery location and insert to into mySQL
	$breweryId = generateUuidV4();
	$brewery = new Brewery($breweryId->$this->brewery->getBreweryLocation(),
		$this->VALID_BREWERY_ADDRESS,
		$this->VALID_BREWERY_AVATAR_URL,
		$this->VALID_BREWERY_DESCRIPTION,
		$this->VALID_BREWERY_EMAIL,
		$this->VALID_BREWERY_NAME,
		$this->VALID_BREWERY_LAT,
		$this->VALID_BREWERY_LONG,
		$this->VALID_BREWERY_PHONE,
		$this->VALID_BREWERY_URL);
	$brewery->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields match our expectations
	$results = Brewery::GetValidBreweryByBreweryLocation($this->getPDO(), $this->getBreweryName());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("brewery"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("FindMeBeer\\FindMeBeer\\Beer", $results);

	//get the result from the array and validate it
	$pdoBrewery = $results[0];

	$this->assertEquals($pdoBrewery->getBreweryId(), $breweryId);
	$this->assertEquals($pdoBrewery->getBreweryId(), $this->brewery->getBreweryId());
	$this->assertEquals($pdoBrewery->getBreweryAddress(), $this->VALID_BREWERY_ADDRESS);
	$this->assertEquals($pdoBrewery->getBreweryAvatarUrl(), $this->VALID_BREWERY_AVATAR_URL);
	$this->assertEquals($pdoBrewery->getBreweryDescription(), $this->VALID_BREWERY_DESCRIPTION);
	$this->assertEquals($pdoBrewery->getBreweryEmail(), $this->VALID_BREWERY_EMAIL);
	$this->assertEquals($pdoBrewery->getBreweryName(), $this->VALID_BREWERY_NAME);
	$this->assertEquals($pdoBrewery->getBreweryLat(), $this->VALID_BREWERY_LAT);
	$this->assertEquals($pdoBrewery->getBreweryLong(), $this->VALID_BREWERY_LONG);
	$this->assertEquals($pdoBrewery->getBreweryPhone(), $this->VALID_BREWERY_PHONE);
	$this->assertEquals($pdoBrewery->getBreweryUrl(), $this->VALID_BREWERY_URL);

}


}

