<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';
$data=json_decode(file_get_contents("php://input"));


$products=$data->products;
$userId=$data->userId;

if(sizeof($products) > 0){
    $numbers1 = rand(111111, 999999);
    $numbers2 = rand(111111, 999999);
    $timeStamp=time();
    $rand = $numbers1.$numbers2;
    $proc_no='PR'.$timeStamp.$rand;
    $procedureQuery="INSERT INTO `procedures`(`proc_no`,`user_id`, `text`) VALUE ('$proc_no','$userId', '')";
    if(mysqli_query($con, $procedureQuery)){
        $last_id = $con->insert_id;
    }
    $values="";
    for ($i=0; $i < sizeof($products); $i++) { 
        $proID = $products[$i]->productId;
        if($i == 0){
            $values = "($proID, '$proc_no')";
        }else{
            $values .= ", ($proID, '$proc_no')";
        }
    }

    if($last_id > 0){
        $sql="INSERT INTO `product_procedure_map`( `product_id`, `proc_no`) VALUES ".$values;
        if(mysqli_query($con, $sql)){
            $response['proc_id']=$last_id;
            $response['proc_no']=$proc_no;
            $response['success']=true;
            $response['message']="Procedure added with corresponding products";
        } else{
            $sqldlt="DELETE FROM `procedures` WHERE id=".$last_id;
            if(mysqli_query($con, $sqldlt)){
                $response['success']=false;
                $response['message']="Error while saving products";
            }else{
                $response['success']=false;
                $response['message']="Created procedure is invalid";
            }
            
        }
    }
    else{
        $response['success']=false;
        $response['message']="Procedure not saved";
    }
}else{
    $response['success']=false;
    $response['message']="Please select atleast one product";
}


echo json_encode($response);

?>