<?php 
session_start();
require_once('db-connect.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $code = addslashes($conn->real_escape_string($_POST['code']));
    $name = addslashes($conn->real_escape_string($_POST['name']));
    $id= $_POST['id'];
    if(!empty($id)){
        $check = $conn->query("SELECT id FROM `tickets` where `code` = '{$code}' and `id` != '{$id}'");
        $sql = "UPDATE `tickets` set `code` = '{$code}', `name` = '{$name}' where `id` = '{$id}'";
    }else{
        $check = $conn->query("SELECT id FROM `tickets` where `code` = '{$code}' ");
        $sql = "INSERT INTO `tickets` (`code`, `name`) VALUES ('{$code}', '{$name}')";
    }

    if($check->num_rows > 0){
        $response['status'] = 'failed';
        $response['error'] = 'Ticket Code Already Exists';
    }else{
        $save = $conn->query($sql);
        if($save){
            $response['status'] = 'success';
            if(empty($id))
                $_SESSION['success_msg'] = "New Ticket has been added successfully.";
            else
                $_SESSION['success_msg'] = "Ticket has been updated successfully.";
        }else{
            $response['status'] = 'failed';
            $response['error'] = 'Saving ticket failed. Error: '.$conn->error;
        }
    }
    echo json_encode($response);
}
$conn->close();
?>