<?php
namespace Vlad11793\ObjectOrientated;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;



class Tag implements \JsonSerializable {
	//use ValidateDate;
	use ValidateUuid;

//CREATE TABLE tag (
//tagId Binary(16),
//tagContent Varchar(32),
//PRIMARY KEY (tagId)
//);

	/**
	 * id for this Tag; this is the primary key
	 * @var Uuid $tagId
	 **/
	private $tagId;

	/**
	 * content  for this Tag;
	 * @var String $tagContent
	 **/
	private $tagContent;


	/**
	 * constructor for this Tag
	 *
	 * @param string|Uuid $newtagId of this Tag or null if a new Tag
	 * @param string $newTagContent string containing url.
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct($newTagId, string $newTagContent) {
		try {
			$this->setTagId($newTagId);
			$this->setTagContent($newTagContent);


		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for TagId
	 * @return Uuid value of TagId
	 **/
	public function getTagId(): Uuid {
		return($this->tagId);
	}

	/**
	 * mutator of tagId
	 * @param Uuid $newTagId
	 * @throws \RangeException if $newTagId is not positive
	 * @throws \TypeError if $newTagId is not a uuid or string
	 **/

	public function setUserId($newTagId): void {
		try {
			$uuid = self::validateUuid($newTagId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->tagId = $uuid;
	}
	// tagContent Name Accessors/ Mutators

	public function getTagContent(): string {
		return $this->tagContent;

	}

	/**
	 * mutator method for Tag Content
	 * @param string $newTagContent
	 * @throws \RangeException if $newTagContent is > 64 characters
	 * @throws \TypeError if $newTagContent is not a string
	 **/

	public function setTagContent(string $newTagContent):void {
		//verify new user FirstName is secure
		$newTagContent = trim($newTagContent);
		$newTagContent = FILTER_VAR($newTagContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//verify size of string is less than 64 characters
		if(strlen($newTagContent)>64){
			throw(new \RangeException("Tag Content is too long"));
		}
		// store Tag Content
		$this->tagContent = $newTagContent;
	}






}