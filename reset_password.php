<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';

$data=json_decode(file_get_contents("php://input"));
$username=$data->username;
$password=$data->password;

$sql = "UPDATE user_details SET password='$password' WHERE user_name='$username'";

if (mysqli_query($con, $sql)) {
  $response['success'] = true;
} else {
  $response['success'] = false;
}

echo json_encode($response);

?>