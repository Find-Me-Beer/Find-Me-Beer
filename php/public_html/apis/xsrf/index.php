<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

use FindMeBeer\FindMeBeer\User;

try {
	//verify the HTTP method being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// if the HTTP method is head check/start the PHP session and set the XSRF token
	if($method === "GET") {

		if(session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		setXsrfCookie();

		$reply->message = "XSRF";
	} else {
		throw (new \InvalidArgumentException("Attempting to get XSRF", 418));
	}
} catch(\Exception  | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();

}
header("Content-Type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);