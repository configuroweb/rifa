<?php 
require_once("db-connect.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ticket_id = $_POST['ticket_id'];
    $draw = $_POST['draw'];
    $insert = $conn->query("INSERT INTO `winners` (`ticket_id`, `draw`) VALUES ('{$ticket_id}', '{$draw}')");
    if($insert){
        $response['status'] = 'success';
    }else{
        $response['error'] = 'Error: '. $conn->error;
    }
}else{
    $response['error'] = 'Error: No data sent.';
}
echo json_encode($response);
$conn->close();
?>