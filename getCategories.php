<?php
 header("Access-Control-Allow-Origin: *");
include 'conn_products.php';
$categoryQuery="SELECT * FROM `categories` WHERE parent_id = -1";

if($query=mysqli_query($conn, $categoryQuery)){
    while($rowCategory=mysqli_fetch_array($query)){
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
                $subCat['id']=$row['id'];
                $subCat['cat_name']=$row['cat_name'];
                $subCat['cat_slug']=$row['cat_slug'];
                $subCat['type']=$row['type'];
                $subCat['cat_description']=$row['cat_description'];
                $subCat['cat_image']=$row['cat_image'];
                $subCategory[]=$subCat;
            }
        }

        $data['sub_category']=$subCategory;
        $response[]=$data;
        
    }
    echo json_encode($response);
}
?>