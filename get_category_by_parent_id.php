<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'conn_products.php';
$data=json_decode(file_get_contents("php://input"));
$category_id=$data->cat_id;
$response= array();
$categoryQuery="SELECT cat_name FROM categories WHERE id= ".$category_id;
if($query1=mysqli_query($conn, $categoryQuery)){
    $row1=mysqli_fetch_assoc($query1);
    $response['category']= $row1['cat_name'];
}
$product_response= array();
$productQuery="SELECT p.id as product_id, p.title, p.product_slug, p.product_alias, p.stock, p.cas, c.id AS cat_id, c.cat_name, c.parent_id FROM products AS p LEFT JOIN product_cat_map AS pc ON p.id=pc.product_id LEFT JOIN categories AS c ON c.id=pc.cat_id WHERE c.id= ".$category_id;
if($query=mysqli_query($conn, $productQuery)){
    while($row=mysqli_fetch_assoc($query)){
        $product_response[]=$row;
    }
}
$response['products'] = $product_response;
echo json_encode($response);
?>