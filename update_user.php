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
$products_names=$data->prodsNames;
$products_names=implode(',', $products_names);
$prodsIds=$data->prodsIds;
$prodsIds=implode(',', $prodsIds);
$subCatProdIds=$data->subCatProdIds;
$subCatProdIds=implode(',', $subCatProdIds);
$subCatProdNames=$data->subCatProdNames;
$subCatProdNames=implode(',', $subCatProdNames);

$user_id=$data->user_id;




$sql = "UPDATE `user_details` SET `user_name`='".$username."', `email`='".$email."', 
`first_name`='".$first_name."', `last_name`='".$last_name."', `password`='".$password."', `user_type`='".$user_type."', 
`accessable_products`='".$products_names."', `acc_prodsIds`='".$prodsIds."', `acc_sub_prods`='".$subCatProdNames."', 
`acc_sub_prodsIds`='".$subCatProdIds."'
  WHERE user_id='$user_id'";
  if(mysqli_query($con,$sql)){
    $response['success'] = true;
    $response['message'] = "User is updated...";
} else {
    $response['success'] = false;
    $response['message'] = "User can not be updated...Try Again";
}

echo json_encode($response);


?>