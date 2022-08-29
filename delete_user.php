<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';

$data=json_decode(file_get_contents("php://input"));

$user_id=$data->user_id;

$sql = "DELETE FROM `user_details` WHERE user_id = '$user_id'";

if(mysqli_query($con,$sql)){
    $response['success'] = true;
    $response['message'] = "User deleted...";
} else {
    $response['success'] = false;
    $response['message'] = "Something went wrong, User cannot be deleted...";
}

echo json_encode($response);


?>