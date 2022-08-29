<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';
$formdata=json_decode(file_get_contents("php://input"));

$proc_id=$formdata->id;
$text=stripslashes($formdata->text);
//$text=$formdata->text;



$sql_ver="SELECT `proc_no`,`text`, `user_id`, `version` FROM `procedures` WHERE proc_no='$proc_id' ORDER BY version DESC limit 1";
if($result_ver=mysqli_query($con, $sql_ver)){
    $row_ver=mysqli_fetch_assoc($result_ver);
    $version=$row_ver['version'];
    $proc_no=$row_ver['proc_no'];
    $user_id=$row_ver['user_id'];
    $updatedVersion=$version+1;
    if($version == 0){
        $sql="UPDATE `procedures` SET `text`='".$text."',`version`='".$updatedVersion."' WHERE proc_no='$proc_id'";
    }else{      
        $sql="INSERT INTO `procedures`(`proc_no`, `text`, `user_id`, `version`) VALUES ('$proc_no','".$text."','$user_id', '$updatedVersion')";

    }
    if(mysqli_query($con,$sql)){
        $response['success']=true;
        $response['message']="Procedure updated";
     
    }else{
        $response['success']=false;
        $response['message']="Procedure not updated";
    }

}else{
    $response['success']=true;
    $response['message']="Version not found";
}


echo json_encode($response);

?>