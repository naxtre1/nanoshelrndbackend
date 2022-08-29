<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
require_once 'jwt/src/BeforeValidException.php';
require_once 'jwt/src/ExpiredException.php';
require_once 'jwt/src/SignatureInvalidException.php';
require_once 'jwt/src/JWT.php';
use \Firebase\JWT\JWT;

$key = "thisisasrcretkeywhichcsnnotbepredict";

include 'connection.php';
$data=json_decode(file_get_contents("php://input"));
$username=$data->username;
$password=$data->password;

 $searchUserQuery = "SELECT user_id, user_name, user_type, accessable_products, acc_prodsIds, acc_sub_prods, acc_sub_prodsIds FROM user_details WHERE user_name = '$username'
  AND password = '$password' ";

if($result=mysqli_query($con, $searchUserQuery)) {
    if(mysqli_num_rows($result) > 0){

        $userdata=[]; 
        $data=[];

        $row=mysqli_fetch_assoc($result);
        $username=$row['user_name'];
        $userId=$row['user_id'];
        $userType=$row['user_type'];
        $accessable_products=explode(',', $row['accessable_products']);
        $acc_prodsIds = explode(',', $row['acc_prodsIds']);
        $acc_sub_prods = explode(',', $row['acc_sub_prods']);
        $acc_sub_prodsIds = explode(',', $row['acc_sub_prodsIds']);

        $token = array(
            "userid" => $userId,
            "userType" => $userType,
            "userName" => $username
        );
        $jwt = JWT::encode($token, $key);
        $userdata['userId']=$userId;
        $userdata['userType']=$userType;
        $userdata['username']=$username;
        $userdata['accessable_products']=$accessable_products;
        $userdata['acc_prodsIds']=$acc_prodsIds;
        $userdata['acc_sub_prods']=$acc_sub_prods;
        $userdata['acc_sub_prodsIds']=$acc_sub_prodsIds;

        $data['userdata']=$userdata;
        $data['token']=$jwt;
        $response['success']=true;
        $response['message']="Login Successful";
        $response['data']=$data;
    }else{
        $response['success']=false;
        $response['message']="Login Failed";
    }
    
    
} else {
    $response['success']=false;
    $response['message']="Mysql failed";
}

echo json_encode($response);


?>