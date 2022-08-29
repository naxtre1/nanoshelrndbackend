<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';

$adminQuery="SELECT * FROM user_details WHERE user_type <> 0";

if($query=mysqli_query($con, $adminQuery)){
    while($row=mysqli_fetch_assoc($query)){
        $response[]=$row;
        
    }
    echo json_encode($response);
}
?>