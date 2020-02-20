<?php
namespace FindMeBeer\FindMeBeer\Test;

use FindMeBeer\FindMeBeer\Tag;


// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Tag  class
 *
 * This is a complete PHPUnit test of the User class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Tweet
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class TagTest extends FindMeBeerTest {
	/**
	 * Profile that created the Tweet; this is for foreign key relations
	 * @var User user
	 **/

//	protected $VALID_TAGID = "1";

	/**
	 * Valid beer style label
	 * @var string $VALID_TAG_CONTENT
	 **/
	protected $VALID_TAG_CONTENT = "Hoppy";
	/**
	 * Test inserting a valid tag and verifying that the mySQL data matches
	 **/
	public function testInsertValidTag() {
		// Count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new User and insert to into mySQL
		$tagId = generateUuidV4();

		// Create a new tag and insert it into mySQL
		$tag = new Tag($tagId, $this->VALID_TAG_CONTENT);
		$tag->insert($this->getPDO());

		//Grab the data from mySQL and check the fields against our expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagId(), $tagId);
		$this->assertEquals($pdoTag->getTagContent(), $this->VALID_TAG_CONTENT);
	}

	/**
	 * Test inserting a tag, editing it, and then updating it
	 */
//	public function testUpdateValidTag() {
//		// Count the number of rows and save it for later
//		$numRows = $this->getConnection()->getRowCount("tag");
//		$tagId = generateUuidV4();
//		// Create a new tag and insert it into mySQL
//		$tag = new Tag($tagId, $this->VALID_TAG_CONTENT);
//		$tag->insert($this->getPDO());
//
//		// Edit the tag and update it in mySQL
//		$tag->setTagContent($this->VALID_TAG_CONTENT);
//		$tag->update($this->getPDO());
//
//		// Grab the data from mySQL and enforce the fields match our expectations
//		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
//		$this->assertEquals($pdoTag->getTagContent(), $this->VALID_TAG_CONTENT);
//	}
	/**
	 * Test creating a tag and then deleting it
	 **/
//	public function testDeleteValidTag() {
//		// Count the number of rows and save it for later
//		$numRows = $this->getConnection()->getRowCount("tag");
//
//		// Create a new tag and insert it into mySQL
//		$tag = new Tag(null, $this->VALID_TAG_CONTENT);
//		$tag->insert($this->getPDO());
//
//		// Delete the tag from mySQL
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
//		$tag->delete($this->getPDO());
//
//		// Grab the data from MySQL and enforce the tag does not exist
//		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
//		$this->assertNull($pdoTag);
//		$this->assertSame($numRows, $this->getConnection()->getRowCount("tag"));
//	}

	/**
	 * Test getting a tag by valid tag id
	 **/
	public function testGetTagByValidTagId() : void {
		// Count the number of rows and save this for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new User and insert to into mySQL
		$tagId = generateUuidV4();
		$tag= new Tag($tagId, $this->VALID_TAG_CONTENT);
		$tag->insert($this->getPDO());
		// Grab the data from mySQL and check the fields against our expectations

		$pdoUser = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoUser->getTagId(), $tagId);
		$this->assertEquals($pdoUser->getTagContent(), $this->VALID_TAG_CONTENT);
	}

	/**
	 * Test getting all tags
	 **/
	public function testGetAllValidTags(): void {
		// Count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new User and insert to into mySQL
		$tagId = generateUuidV4();

		// Create a new tag and insert it into mySQL
		$tag = new Tag($tagId, $this->VALID_TAG_CONTENT);
		$tag->insert($this->getPDO());

		// Grab the data from mySQL and enforce the fields match our expectations
		$results = Tag::getAllTags($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FindMeBeer\FindMeBeer\Tag", $results);

		// Grab the result from the array and validate it
		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getTagId(), $tagId);
		$this->assertEquals($pdoTag->getTagContent(), $this->VALID_TAG_CONTENT);
	}

}
