<?php

namespace FindMeBeer\FindMeBeer\Test;

use FindMeBeer\FindMeBeer\{Beer, BeerTag, Brewery, Tag};


//grab the classes under scrutiny
require_once (dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the BeerTag class							$tag = $post 		likePostId = beerTagBeerId
 *																				$beer = $profile 		likeProfileId = beerTagTagId
 *																								Like = BeerTag
 * This is a complete PHPUnit test of the BeerTag class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see \FindMeBeer\FindMeBeer\BeerTag
 * @see \FindMeBeer\FindMeBeer\Brewery
 * @see \FindMeBeer\FindMeBeer\Tag
 * @author Patrick Leyba <pleyba4@cnm.edu>
 **/

class BeerTagTest extends DataDesignTest {

	/**
	 * Beer this is to test foreign key relations inside BeerTag
	 * @var
	 **/
	protected $beer;

	/**
	 * Brewery that created the beer; this is to test foreign key relations inside beerTag
	 * @var Brewery
	 **/

	protected $brewery;

	/**
	 * Tag that created the Tag and BerTag; this is to test foreign key relations
	 * @var Tag
	 **/
	protected $tag;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() : void {
		//run the default setUp() method first
		parent::setUp();

		//create a beer  a tag and a brewery for the beerTag test example

		$beer = "goodforyou";
		$tag = "pofjvijiovhj";
		$brewery = 'kljlkjsllk';

		//TODO add the rest of the parameters needed to instantiate Brewery Tag and Beer
		$this->brewery = new Brewery(generateUuidV4(), "123 main st Albuqueruqe NM 87102", "http://meows.cat.com", "A relaxed atmosphere", "brewery@email.com", "32° 18.385' N", "122° 36.875' W", "Marble Brewery", "505-798-7980", "www.marble.com");
		$this->brewery->insert($this->getPDO());

		$this->tag = new Tag(generateUuidV4(), "beer tag content goes here");
		$this->tag->insert($this->getPDO());

		$this->beer = new Beer(generateUuidV4(), "5.25%", $this->brewery->getbreweryId(), "hoppy", "Duff", "Lager");
		$this->beer->insert($this->getPDO());






		}

	/**
	 * test inserting a valid BeerTag and verify that the actual mySQL data matches
	 **/
	public function testInsertValidBeerTag() : void {
		//count the current number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("beerTag");

		//create a beerTag and insert
		$beerTag = new BeerTag($this->tag->getTagId(), $this->beer->getBeerId());
		$beerTag->insert($this->getPDO());

		//verify the rowCount matches
		$pdoBeerTag = BeerTag::getBeerTagBeerIdAndBeerTagTagId($this->getPDO(), $this->beer->getBeerId(), $this->tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beerTag"));
		$this->assertEquals($pdoBeerTag->getBeerTagBeerId(), $this->tag->getTagId());
		$this->assertEquals($pdoBeerTag->getLikeProfileId(), $this->profile->getProfileId());
	}

	/**
	 * test getting a BeerTag by tag id and verify
	 **/
	public function testGetBeerTagByBeerTagTagId() {
		//count the current number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("beerTag");

		//create a like and insert
		$beerTag = new BeerTag($this->beer->getBeerTagBeerId(), $this->tag->getBeerTagTagId());
		$beerTag->insert($this->getPDO());

		//grab from mysql and verify count
		$results = BeerTag::getBeerTagsByBeerTagTagId($this->getPDO(), $this->tag->getBeerTagBeerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beerTag"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FindMeBeer\\BeerTag", $results);

		//grab the first array index and validate
		$pdoBeerTag = $results[0];
		$this->assertEquals($pdoBeerTag->getBeerTagBeerId(), $this->beer->getBeerTagBeerId());
		$this->assertEquals($pdoBeerTag->getBeerTagTagId(), $this->tag->getBeerTagTagId());
	}

	/**
	 * test grabbing a BeerTag by a tag id that does not exist
	 **/
	public function testGetInvalidBeerTagTagId() {
		$beerTag = BeerTag::getBeerTagByBeerTagTagId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $beerTag);
	}

	/**
	 * test getting a BeerTag by BeerTagBeerId and verify
	 **/
	public function testGetBeerTagByBeerTagBeerId() {
		//count the current number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("beerTag");

		//create a beerTag and insert
		$beerTag = new BeerTag($this->beer->getBeerTagBeerId(), $this->tag->getBeerTagTagId());
		$beerTag->insert($this->getPDO());

		//grab from mysql and verify count
		$results = BeerTag::getBeerTagsByBeerTagBeerId($this->getPDO(), $this->beer->getBeerTagBeerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beerTag"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FindMeBeer\\BeerTag", $results);

		//grab the first array index and validate
		$pdoBeerTag = $results[0];
		$this->assertEquals($pdoBeerTag->getBeerTagBeerId(), $this->beer->getBeerTagBeerId());
		$this->assertEquals($pdoBeerTag->getBeerTagTagId(), $this->tag->getBeerTagtagId());
	}

	/**
	 * test grabbing a BeerTag by a BeerTagBeerId that does not exist
	 **/
	public function testGetInvalidBeerTagByBeerTagBeerId() {
		$beerTag = BeerTag::getLikesByBeerTagBeerId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $beerTag);
	}

	/**
	 * test getting a BeerTag by beerId and tagId, and verify
	 **/
	public function testGetBeerTagsByBeerTagBeerIdAndBeerTagTagId() {
		//count the current number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("beerTag");

		//create a beerTag and insert
		$beerTag = new BeerTag($this->beer->getBeerId(), $this->tag->getTagId());
		$beerTag->insert($this->getPDO());

		//grab from mysql and verify count
		$result = Like::getLikeByLikePostIdAndLikeProfileId($this->getPDO(), $this->beer->getBeerId(), $this->tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("like"));
		$this->assertEquals($result->getBeerTagBeerId(), $this->beer->getBeerId());
		$this->assertEquals($result->getBeerTagTagId(), $this->tag->getTagId());
	}

	/**
	 * test grabbing a beerTag that does not exist
	 **/
	public function testGetInvalidBeerTagByBeerIdAndTagId() {
		$beerTag = beerTag ::getLikeByLikePostIdAndLikeProfileId($this->getPDO(), generateUuidV4(), generateUuidV4());
		$this->assertNull($beerTag);
	}

	/**
	 * test grabbing all beerTags
	 **/
	public function testGetAllValidBeerTags() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beerTag");

		//create a beerTag and insert
		$beerTag = new BeerTag($this->beer->getBeerId(), $this->tag->getTagId());
		$beerTag->insert($this->getPDO());

		//grab the posts from mysql, verify row count and namespace is correct
		$results = BeerTag::getAllBeerTags($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beerTags"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FindMeBeer\\BeerTag", $results);

		//verify that all fields match
		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getBeerTagBeerId(), $this->beer->getBeerId());
		$this->assertEquals($pdoTag->getBeerTagTagId(), $this->tag->getTagId());
	}
}
