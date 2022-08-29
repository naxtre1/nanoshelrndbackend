<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';

$data=json_decode(file_get_contents("php://input"));

$username=$data->username;
$email=$data->email;
$first_name=$data->first_name;
$last_name=$data->last_name;
$password=$data->password;
$user_type=$data->user_type;
$products_names=$data->products_names;
$products_names = implode(',', $products_names);
$prodsIds=$data->prodsIds;
$prodsIds = implode(',', $prodsIds);
$subProds = $data->subProds;
$subProds = implode(',', $subProds);
$subProdsIds = $data->subProdsIds;
$subProdsIds = implode(',', $subProdsIds);

$sql = "INSERT INTO `user_details`
(`user_type`, `user_name`, `first_name`, `last_name`, `email`, 
`password`, `accessable_products`, `acc_prodsIds`, `acc_sub_prods`, `acc_sub_prodsIds`) 
VALUE ('$user_type', '$username', '$first_name', '$last_name', '$email', '$password', '$products_names',
'$prodsIds', '$subProds', '$subProdsIds')";

if(mysqli_query($con,$sql)){
    $response['success'] = true;
    $response['message'] = "User is added...";
} else {
    $response['success'] = false;
    $response['message'] = "User can not be added...Try Again";
}

echo json_encode($response);


?>