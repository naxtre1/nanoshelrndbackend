<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
include 'connection.php';
include 'conn_products.php';

$formdata=json_decode(file_get_contents("php://input"));
    $userId=$formdata->userId;

$sql="SELECT * FROM procedures";
$sql = "SELECT p.*, u.user_name, CONCAT( u.first_name, ' ' ,u.last_name) AS fullname FROM `procedures` as p LEFT JOIN user_details as u ON u.user_id = p.user_id";
if($result=mysqli_query($con,$sql)){
    while($row= mysqli_fetch_assoc($result)){
        $pro_no = $row['proc_no'];
        $category_List = "";
        $sql2 = "SELECT GROUP_CONCAT(`product_id`) as products FROM `product_procedure_map` WHERE `proc_no` = '$pro_no' group by `proc_no`";
        $result2 = mysqli_query($con,$sql2);
        $count = mysqli_num_rows($result2);
        if($count>0){
            $row2 = mysqli_fetch_assoc($result2);
            $product_list = $row2['products'];
            $sqlProduct="SELECT DISTINCT(c.cat_name) as category_name FROM `products` as p LEFT JOIN product_cat_map as pcm on p.id = pcm.product_id LEFT JOIN categories as c on c.id = pcm.cat_id WHERE p.id IN ($product_list)";
            if($result3=mysqli_query($conn,$sqlProduct)){ 
                while($row3=mysqli_fetch_assoc($result3)){
                    if(empty($category_List)){
                        $category_List = $row3['category_name'];
                    }else{
                        $category_List .= ", ".$row3['category_name'];
                    }
                }
            }
        }
        $row['category'] = $category_List;
        $data[]=$row;
    }
    $response['success']=true;
    $response['message']="Data fetched successfully";
    $response['data']=$data;
}else{
    $response['success']=false;
    $response['message']="Mysqli Err";
}
echo json_encode($response);
?>