<?php

 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");


include 'conn_products.php';
include 'connection.php';


$data=json_decode(file_get_contents("php://input"));
$user_id=$data->userId;
$accProdsQuery = "SELECT acc_prodsIds, acc_sub_prodsIds FROM user_details WHERE user_id = $user_id";
$categoryQuery="SELECT * FROM `categories` WHERE parent_id = -1";
$prodIds[] = array();
$subProdIds[] = array();
$response = array();

if($query=mysqli_query($con, $accProdsQuery)){
    while($row=mysqli_fetch_assoc($query)){
        $prodIds=explode(',', $row['acc_prodsIds']);
        $subProdsId=explode(',', $row['acc_sub_prodsIds']);    
    }
}
if($query=mysqli_query($conn, $categoryQuery)){
    while($rowCategory=mysqli_fetch_array($query)){
        $mprodId = $rowCategory['id'];
        
        if(in_array($mprodId, $prodIds)) {
            $data = array();
            $data['id']=$rowCategory['id'];
            $data['cat_name']=$rowCategory['cat_name'];
            $data['cat_slug']=$rowCategory['cat_slug'];
            $data['type']=$rowCategory['type'];
            $data['cat_description']=$rowCategory['cat_description'];
            $data['cat_image']=$rowCategory['cat_image'];
            $subCategory = array();
            $query1="SELECT * FROM `categories` WHERE parent_id = ".$rowCategory['id'];
            if($result=mysqli_query($conn, $query1)){
                while($row=mysqli_fetch_array($result)){
                    $subProdId = $row['id'];
                    if(in_array($subProdId, $subProdsId)) { 
                        $subCat['id']=$row['id'];
                        $subCat['cat_name']=$row['cat_name'];
                        $subCat['cat_slug']=$row['cat_slug'];
                        $subCat['type']=$row['type'];
                        $subCat['cat_description']=$row['cat_description'];
                        $subCat['cat_image']=$row['cat_image'];
                        $subCategory[]=$subCat;
                    }   
                }
            }
            $data['sub_category']=$subCategory;
            $response[]=$data;
        }   
    }
    echo json_encode($response);
}
?>