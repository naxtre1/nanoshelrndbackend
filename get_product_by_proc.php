<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';
include 'conn_products.php';
$formdata=json_decode(file_get_contents("php://input"));

$proc_id=$formdata->id;

$sql="SELECT `product_id` FROM `product_procedure_map` WHERE `proc_no`='$proc_id'";
if($result=mysqli_query($con,$sql)){
   while($row=mysqli_fetch_assoc($result)){
       $products[]=$row;
   }

   $value="(";
   for ($i=0; $i < sizeof($products); $i++) { 
       if($i==0){
           $value=$value.$products[$i]['product_id'];
       }else{
           $value=$value.','.$products[$i]['product_id'];
       }
   }
   $value=$value.')';
   $sqlProduct="SELECT p.*,  c.cat_name FROM `products` as p LEFT JOIN product_cat_map as pcm on p.id = pcm.product_id LEFT JOIN categories as c on c.id = pcm.cat_id WHERE p.id IN $value";
   if($result2=mysqli_query($conn,$sqlProduct)){
        while($row2=mysqli_fetch_assoc($result2)){
            $products2[]=$row2;
        }
        $response['success']=true;
        $response['data']=$products2;
        $response['message']="products foun";
    }else{
        $response['success']=false;
        $response['message']="Mysql Err";
    }
}else{
    $response['success']=false;
    $response['message']="Procedure not found";
}

echo json_encode($response);

?>