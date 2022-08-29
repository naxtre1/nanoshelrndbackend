<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'conn_products.php';
$data=json_decode(file_get_contents("php://input"));

$category_id=$data->category_id;
$searchVal=$data->keyword;

$productQuery="SELECT p.id as product_id, p.title, p.product_slug, p.product_alias, p.stock, p.cas, c.id AS cat_id, c.cat_name, c.parent_id FROM products AS p LEFT JOIN product_cat_map AS pc ON p.id=pc.product_id LEFT JOIN categories AS c ON c.id=pc.cat_id WHERE c.id= ".$category_id ." AND p.title LIKE '%".$searchVal."%' ";

if($query=mysqli_query($conn, $productQuery)){
    while($row=mysqli_fetch_assoc($query)){
        $response[]=$row;

    }
    echo json_encode($response);
}
?>