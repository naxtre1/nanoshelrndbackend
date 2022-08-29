<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';

$formdata=json_decode(file_get_contents("php://input"));
$procedureId = $formdata->id;
$version_no = $formdata->version_no;
$response = array();
$sql="SELECT text FROM `procedures` WHERE proc_no='$procedureId' AND version='$version_no'";
if($result=mysqli_query($con,$sql)){
    if(mysqli_num_rows($result)>0){
        $data= mysqli_fetch_assoc($result);
        $str = preg_replace('~/"~', '', $data);
        $str1 = preg_replace('~\"~', '', $data);

        $response['success']=true;
        $response['message']="Data fetched successfully";
        $response['data']=$str1;
        
        $response['text'] = $str1['text'];

    }else{
        $response['success']=false;
        $response['message']="No data found";
    }
}else{
    $response['success']=false;
    $response['message']="Mysqli Err";
}
echo json_encode($response);
?>