<?php

namespace FindMeBeer\FindMeBeer\Test;

use FindMeBeer\FindMeBeer\{Brewery, Beer, BeerTag, Tag};

// grab the class you're testing
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * unit test for Beer class
 *
 * This is a PHPUnit test for the Beer Class. All PDO methods are tested for valid inputs
 *
 * @see Beer
 * @author Reece Nunn <rnunn4@cnm.edu>
 * @modeled after BeerTest.php by Merri Zibert <mzibert@cnm.edu>
 */
class BeerTest extends FindMeBeerTest {
	/**
	 * Valid beer id to use; this starts null and is assigned later
	 * @var int $VALID_BEERID
	 */
	protected $VALID_BEERID = null;

	/**
	 * valid beer abv generated for alcohol by volume
	 * @var float $VALID_BEERABV
	 */
	protected $VALID_BEERABV = 9.64;

	/**
	 * valid updated float/decimal of beer abv
	 * @var float $VALID_BEERABV2
	 */
	protected $VALID_BEERABV2 = 12.75;

	/**
	 * valid beer description
	 * @var string $VALID_BEERDESCRIPTION
	 */
	protected $VALID_BEERDESCRIPTION = "This beer is light and frothy with a slight hint of pine nuts and butterscotch.";

	/**
	 * valid beer name
	 * @var string $VALID_BEERNAME
	 */
	protected $VALID_BEERNAME = "Pine Nut Butterscotch Beer";

	/**
	 * valid beer type
	 * @var $VALID_BEERTYPE
	 */
	protected $VALID_BEERTYPE = "Malt";

	/**
	 * brewery that created the beer; for foreign key relations
	 * @var Brewery brewery
	 */
	protected $brewery = null;

	/**
	 * brewery that created the beer; for foreign key relations
	 * @var BeerTag beerTag
	 */
	protected $beerTag = null;

	/**
	 * tag that beerTag needs to exist; for foreign key relations
	 * @var Tag tag
	 */
	protected $tag = null;

	/**
	 * create dependent objects before running each test
	 * @throws \Exception
	 */
	public final function setUp(): void {
		//run setUp() method first
		parent::setUp();

		//create and insert brewery that created the beer
		$breweryId = generateUuidV4();
		$this->brewery = new Brewery($breweryId,
			"111 Marble Ave NW, Albuquerque, NM 87102",
			"https://gravatar.com/avatar/07e75bbcdc08eca3d8db273bc7d3f7f8?s=400&d=robohash&r=x",
			"Founded in 2008 in the heart of downtown Albuquerque, Marble Brewery is devoted to brewing
			 premium craft beer that satisfies the thirsts and discriminating tastes of our diverse and loyal customers. 
			 Not only do we brew quality craft beer classics, our fresh cutting-edge specials relentlessly push boundaries 
			 and raise expectations. We package a variety of styles and distribute throughout New Mexico, Arizona, Southwest
			 Texas and Southwest Colorado.",
			"marblebrewery@marble.com",
			"Marble Brewery",
			-54.6666666,
			-106.665270,
			"(505)243-2739",
			"https://marblebrewery.com/");
		$this->brewery->insert($this->getPDO());

		//TODO create a tag and insert it into the database
		$tagId = generateUuidV4();
		$this->tag = new Tag(
			$tagId,
			"ThisIsTag");
	}

	/**
	 * test inserting valid beer and verify the mySQL data matches
	 */
	public function testInsertValidBeer() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beer");

		//create a new Beer and insert it into mySQL
		$beerId = generateUuidV4();
		$beer = new Beer($beerId,
			$this->VALID_BEERABV,
			$this->brewery->getbreweryId(),
			$this->VALID_BEERDESCRIPTION,
			$this->VALID_BEERNAME,
			$this->VALID_BEERTYPE);
		$beer->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match our expectations
		$pdoBeer = Beer::getBeerByBeerId($this->getPDO(), $beer->getBeerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
		$this->assertEquals($pdoBeer->getBeerId(), $this->VALID_BEERID);
		$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
		$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
		$this->assertEquals($pdoBeer->getBeerType(), $this->VALID_BEERTYPE);
	}

	/**
	 * test inserting a valid beer, modifying it and then updating it
	 */
	public function testUpdateValidBeer() :void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beer");

		// create a new Beer and insert to into mySQL
		$beerId = generateUuidV4();
		$beer = new Beer($beerId, $this->VALID_BEERABV, $this->brewery->getbreweryId(), $this->VALID_BEERDESCRIPTION, $this->VALID_BEERNAME, $this->VALID_BEERTYPE);
		$beer->insert($this->getPDO());

		// edit this Beer and insert it into mySQL
		$beer->setBeerAbv($this->VALID_BEERABV2);
		$beer->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoBeer = Beer::getBeerByBeerId($this->getPDO(), $beer->getBeerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
		$this->assertEquals($pdoBeer->getBeerId(), $this->VALID_BEERID);
		$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV2);
		$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
		$this->assertEquals($pdoBeer->getBeerType(), $this->VALID_BEERTYPE);
	}

	/**
	 * test creating a beer and deleting it
	 */
	public function testDeleteValidBeer(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beer");

		//create a new Beer and insert it into mySQL
		$beerId = generateUuidV4();
		$beer = new Beer($beerId, $this->VALID_BEERABV, $this->brewery->getBreweryId(),
			$this->VALID_BEERDESCRIPTION, $this->VALID_BEERNAME, $this->VALID_BEERTYPE);
		$beer->insert($this->getPDO());

		//delete the beer from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
		$beer->delete($this->getPDO());

		//grab the Beer from mySQL and enforce the Beer does not exist
		$pdoBeer = Beer::getBeerByBeerId($this->getPDO(), $beer->getBeerId());
		$this->assertNull($pdoBeer);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("beer"));
	}

	/**
	 * test getting all beers
	 */
	public function testGetValidBeers() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beer");

		// create a new beer and insert it into mySQL
		$beerId = generateUuidV4();
		$beer = new Beer($beerId,
			$this->VALID_BEERABV,
			$this->brewery->getbreweryId(),
			$this->VALID_BEERDESCRIPTION,
			$this->VALID_BEERNAME,
			$this->VALID_BEERTYPE);
		$beer->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Beer::getAllBeer($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FindMeBeer\\FindMeBeer\\Beer", $results);

		//grab the result from the array and validate it
		$pdoBeer = $results[0];
		$this->assertEquals($pdoBeer->getBeerId(), $beerId);
		$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
		$this->assertEquals($pdoBeer->getBeerBreweryId(), $this->brewery->getbreweryId());
		$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERTYPE);
	}

	/**
	 * test inserting a beer and grabbing it by its id
	 */
	public function testGetValidBeerByBeerId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beer");

		// create a new beer and insert it into mySQL
		$beerId = generateUuidV4();
		$beer = new Beer($beerId,
			$this->VALID_BEERABV,
			$this->brewery->getbreweryId(),
			$this->VALID_BEERDESCRIPTION,
			$this->VALID_BEERNAME,
			$this->VALID_BEERTYPE);
		$beer->insert($this->getPDO());

		//grab data from database and enforce it matches expectations
		$pdoBeer = Beer::getBeerByBeerId($this->getPDO(), $beer->getBeerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
		$this->assertEquals($pdoBeer->getBeerId(), $beerId);
		$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
		$this->assertEquals($pdoBeer->getBeerBreweryId(), $this->brewery->getbreweryId());
		$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERTYPE);
	}

	/**
	 * test inserting a beer and grabbing it by its beer brewery id
	 */
	public function testGetValidBeerByBeerBreweryId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beer");

		// create a new beer and insert it into mySQL
		$beerId = generateUuidV4();
		$beer = new Beer($beerId,
			$this->VALID_BEERABV,
			$this->brewery->getbreweryId(),
			$this->VALID_BEERDESCRIPTION,
			$this->VALID_BEERNAME,
			$this->VALID_BEERTYPE);
		$beer->insert($this->getPDO());

		//grab the data from mySQL and check the fields against our expectations
		$results = Beer::getBeerByBeerBreweryId($this->getPDO(), $this->brewery->getBreweryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FindMeBeer\\FindMeBeer\\Beer", $results);

		//get the result from the array and validate it
		$pdoBeer = $results[0];
		$this->assertEquals($pdoBeer->getBeerId(), $beerId);
		$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
		$this->assertEquals($pdoBeer->getBeerBreweryId(), $this->brewery->getbreweryId());
		$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERTYPE);
	}

	/**
	 * tests getting beer by beer type
	 */
	public function testGetValidBeerByBeerType() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("beer");

		// create a new beer and insert it into mySQL
		$beerId = generateUuidV4();
		$beer = new Beer($beerId,
			$this->VALID_BEERABV,
			$this->brewery->getbreweryId(),
			$this->VALID_BEERDESCRIPTION,
			$this->VALID_BEERNAME,
			$this->VALID_BEERTYPE);
		$beer->insert($this->getPDO());

		//grab the data from mySQL and check it matches our expectations
		$results = Beer::getBeerByBeerType($this->getPDO(), $beer->getBeerType());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FindMeBeer\\FindMeBeer\\Beer", $results);

		//get the result from the array and validate it
		$pdoBeer = $results[0];
		$this->assertEquals($pdoBeer->getBeerId(), $beerId);
		$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
		$this->assertEquals($pdoBeer->getBeerBreweryId(), $this->brewery->getbreweryId());
		$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERTYPE);
	}

	/**
	 * tests getting beer by tag id
	 */
	public function testGetValidBeerByTagId() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("beer");

		// create a new beer and insert it into mySQL
		$beerId = generateUuidV4();
		$beer = new Beer($beerId,
			$this->VALID_BEERABV,
			$this->brewery->getbreweryId(),
			$this->VALID_BEERDESCRIPTION,
			$this->VALID_BEERNAME,
			$this->VALID_BEERTYPE);
		$beer->insert($this->getPDO());

		//TODO create a beertag and insert it into the database (use the beerId and tagId accessors for foreign keys on beerTag)

		// create a new tag and insert it into mySQL
		$beerTagId = generateUuidV4();
		$beerTag = new BeerTag(
			$beerId,
			$this->VALID_BEERABV,
			$this->brewery->getbreweryId(),
			$this->VALID_BEERDESCRIPTION,
			$this->VALID_BEERNAME,
			$this->VALID_BEERTYPE);
		$beer->insert($this->getPDO());

		//grab the data from mySQL and check the fields against our expectations
		$results = Beer::getBeerByTagId($this->getPDO(), $this->beerTag->getBeerTagTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FindMeBeer\\FindMeBeer\\Beer", $results);

		//grab the result from the resulting array and validate it
		$pdoBeer = $results[0];
		$this->assertEquals($pdoBeer->getBeerId(), $beerId);
		$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
		$this->assertEquals($pdoBeer->getBeerBreweryId(), $this->brewery->getbreweryId());
		$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERTYPE);

	}


}