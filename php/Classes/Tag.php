<?php
namespace FindMeBeer\FindMeBeer;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;



class Tag implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;


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
	 * @param string $newTagContent string containing content.
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

	public function setTagId($newTagId): void {
		try {
			$uuid = self::validateUuid($newTagId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the Tag Id
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
		if($newTagContent === null ){
				$this->tagContent = null;
		}

		//verify new tag content is secure
		$newTagContent = trim($newTagContent);
		$newTagContent = filter_var($newTagContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//verify if tag content is valid

		if(empty($newTagContent) === true){
				throw(new\InvalidArgumentException("tag content insecure"));
		}
		//verify size of string is less than 32characters
		if(strlen($newTagContent)>32){
			throw(new \RangeException("Tag Content is too long"));
		}
		// store Tag Content
		$this->tagContent = $newTagContent;
	}

	/**
	 * inserts this Tag profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO tag(tagId, tagContent) VALUES(:tagId, :tagContent)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["tagId" => $this->tagId->getBytes(), "tagContent" => $this->tagContent];
		$statement->execute($parameters);

	}
	/**
	 * deletes this Tag Id from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM tag WHERE tagId = :tagId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["tagId" => $this->tagId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * gets the Tag by TagId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $tagId message id to search for
	 * @return ?Tag found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getTagByTagId(\PDO $pdo, $tagId): ?Tag {
		// sanitize the tag id before searching
		try {
			$tagId = self::validateUuid($tagId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT tagId, tagContent FROM tag WHERE tagId = :tagId";
		$statement = $pdo->prepare($query);

		// bind the Tag ID to the place holder in the template
		$parameters = ["tagId" => $tagId->getBytes()];
		$statement->execute($parameters);

		// grab the tag from mySQL
		try {
			$tag = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$tag = new Tag($row["tagId"], $row["tagContent"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($tag);
	}


	//getAllTags
	/**
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Tags found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getAllTags (\PDO $pdo) : \SplFixedArray {
		//create query template
		$query = "SELECT tagId, tagContent FROM tag";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of tags
		$tags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tag = new Tag($row["tagId"], $row["tagContent"]);
				$tags[$tags->key()] = $tag;
				$tags->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($tags);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["tagId"] = $this->tagId;
		$fields["tagContent"] = $this->tagContent;
		return ($fields);
	}


}