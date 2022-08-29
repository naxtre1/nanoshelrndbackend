<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';

$data=json_decode(file_get_contents("php://input"));

$user_id=$data->user_id;

$response = array();
$sql = "SELECT * FROM `user_details` WHERE user_id = '$user_id'";

if($result=mysqli_query($con,$sql)){
    if(mysqli_num_rows($result)>0){
        $data= mysqli_fetch_assoc($result);

        $response['success']=true;
        $response['message']="Data fetched successfully";
        $response['data']=$data;

    }else {
        $response['success']=false;
        $response['message']="Data not found...";
    }
}else {
    $response['success']=false;
    $response['message']="Data not found...";
}
echo json_encode($response);


?>