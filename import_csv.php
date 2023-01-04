<?php 
session_start();
include_once('db-connect.php');

/**
 * Check if CSV File has been sent successfully otherwise return error
 */
if(isset($_FILES['fileData']) && !empty($_FILES['fileData']['tmp_name'])){

    // Read CSV File
    $csv_file = fopen($_FILES['fileData']['tmp_name'], "r"); 

    // Row Iteration
    $rowCount = 0;

    //Data to insert for batch insertion
    $data = [];

    // Read CSV Data by row
    while(($row = fgetcsv($csv_file, 1000, ",")) !== FALSE){
        if($rowCount > 0){
            //Sanitizing Data
            $name = addslashes($conn->real_escape_string($row[0]));
            $phone = addslashes($conn->real_escape_string($row[1]));
            $email = addslashes($conn->real_escape_string($row[2]));

            // Add Row data to insert value
            $data[] =  "('{$name}', '{$phone}', '{$email}')";
        }
        $rowCount++;
    }

    // Close the CSV File
    fclose($csv_file);

    /**
     * Check if there's a data to insert otherwise return error
     */
    if(count($data) > 0) {
        // Convert Data values from array to string w/ comma seperator
        $insert_values = implode(", ", $data);

        //MySQL INSERT Statement
        $insert_sql = "INSERT INTO `members` (`name`, `phone`, `email`) VALUES {$insert_values}";

        // Execute Insertion
        $insert = $conn->query($insert_sql);

        if($insert){
            // Data Insertion is successful
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Data has been imported succesfully.';
        }else{
            // Data Insertion has failed
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Import Failed! Error: '. $conn->error;
        }
    }else{
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'CSV File Data is empty.';
    }

}else{
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'CSV File Data is missing.';
}
$conn->close();

header('location: ./');
exit;
?>