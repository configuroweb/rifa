<?php 
require_once('db-connect.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $get = $conn->query("SELECT * FROM `tickets` where `id` = '{$id}'");
    if($get->num_rows > 0){
        $response['status'] = 'success';
        $response['data'] = $get->fetch_assoc();
    }else{
        $response['error'] = "Error: ". $conn->error;
    }
}else{
    $response['error'] = "No data has been sent";
}
echo json_encode($response);
$conn->close();
?>