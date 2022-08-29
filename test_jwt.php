<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';

require_once 'jwt/src/BeforeValidException.php';
require_once 'jwt/src/ExpiredException.php';
require_once 'jwt/src/SignatureInvalidException.php';
require_once 'jwt/src/JWT.php';


use \Firebase\JWT\JWT;

$key = "hcfhfhgfhgfvhfhfhfgvhfhgfvhfhfggfy";
$token = array(
   "userid" => "25",
   "userType" => "2"
);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
*/
$jwt = JWT::encode($token, $key);
$decoded = JWT::decode($jwt, $key, array('HS256'));

// print_r($jwt);
// print_r($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

$decoded_array = (array) $decoded;

$response = $decoded;

/**
* You can add a leeway to account for when there is a clock skew times   between
* the signing and verifying servers. It is recommended that this leeway should
* not be bigger than a few minutes.
*
* Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
*/
   JWT::$leeway = 60; // $leeway in seconds
   $decoded = JWT::decode($jwt, $key, array('HS256'));

    echo json_encode($response);
?>