<?php 
include "../connection.php";
header("Content-Type: application/json");

// Check if admin_email and admin_password are set
if (isset($_POST['admin_email']) && isset($_POST['admin_password'])) {
    
    $adminEmail = trim($_POST['admin_email']);
    $adminPassword = trim($_POST['admin_password']); // plain text as in DB

    // Query the database for matching admin
    $sqlQuery = "SELECT * FROM admins_table WHERE admin_email='$adminEmail' AND admin_password='$adminPassword'";
    $resultOfQuery = $connectNow->query($sqlQuery);

    if ($resultOfQuery->num_rows > 0) {
        $adminRecord = array();
        while ($rowFound = $resultOfQuery->fetch_assoc()) {
            $adminRecord[] = $rowFound;
        }

        echo json_encode(array(
            "success" => true,
            "adminData" => $adminRecord[0]
        ));
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "Invalid email or password"
        ));
    }
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Missing email or password"
    ));
}
?>
