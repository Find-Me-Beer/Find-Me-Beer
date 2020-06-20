<?php

require_once dirname(__DIR__, 3) . "/../../Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FindMeBeer\FindMeBeer\User;

/**
 * api for handling login / sign in
 *
 * @author Reece Nunn <rmnunn5@gmail.com>
 **/

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}

	//grab mySQL statement
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/beerme.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//If method is post handle the login logic
	if($method === "POST") {
		//make sure the XSRF Token is valid
		verifyXsrf();

		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check to make sure the password and email field is not empty.s
		if(empty($requestObject->userEmail) === true) {
			throw(new \InvalidArgumentException("Email address not provided.", 401));
		} else {
			$userEmail = filter_var($requestObject->userEmail, FILTER_SANITIZE_EMAIL);
		}

		if(empty($requestObject->userPassword) === true) {
			throw(new \InvalidArgumentException("Must enter a password.", 401));
		} else {
			$userPassword = $requestObject->userPassword;
		}

		//grab the user from the database by the email provided
		$user = User::getUserByUserEmail($pdo, $userEmail);
		if(empty($user) === true) {
			throw(new InvalidArgumentException("Invalid Email", 401));
		}
		$user->setUserActivationToken(null);
		$user->update($pdo);

		//verify hash is correct
		if(password_verify($requestObject->userPassword, $user->getUserHash()) === false) {
			throw(new \InvalidArgumentException("Password or email is incorrect.", 401));
		}

		//grab user from database and put into a session
		$user = User::getUserByUserId($pdo, $user->getUserId());

		$_SESSION["user"] = $user;

		//create the Auth payload
		$authObject = (object) [
			"userId" =>$user->getUserId(),
			"userUsername" => $user->getUserUsername()
		];

		// create and set the JWT TOKEN
		setJwtAndAuthHeader("auth",$authObject);

		$reply->message = "Login was successful.";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request", 418));
	}

	//if an exception was thrown
} catch(Exception | TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
echo json_encode($reply);