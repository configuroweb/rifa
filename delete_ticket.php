
<?php
session_start();
require_once('db-connect.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $delete = $conn->query("DELETE FROM `tickets` where id = '{$id}'");
    if ($delete) {
        $response['status'] = 'success';
        $_SESSION['success_msg'] = "Ticket eliminado correctamente";
    } else {
        $response['error'] = 'Error: ' . $conn->error;
    }
}
echo json_encode($response);
$conn->close();
?>