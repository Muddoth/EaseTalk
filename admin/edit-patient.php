<?php
include("../connection.php");

if (!$database) {
    die("Database connection failed.");
}

if ($_POST) {
    // Sanitize input data
    $name = trim($_POST['name']);
    $nic = trim($_POST['nic']);
    $oldemail = trim($_POST['oldemail']);
    $email = trim($_POST['email']);
    $tele = trim($_POST['Tele']);
    $diagnosis = trim($_POST['diagnosis']);
    $dob = trim($_POST['dob']);
    $id = intval($_POST['id00']); // Ensure that ID is an integer

    // Check if passwords match
    if ($password === $cpassword) {
        $error = '3'; // Initial error state for password match

        // Check if the email already exists in the 'patient' table but not for the current user
        $result = $database->query(
            "SELECT pid FROM patient WHERE pemail='$email' AND pid != '$id'"
        );

        // If the email already exists, set an error
        if ($result->num_rows == 1) {
            $error = '1'; // Email already exists
        } else {
            // Update patient information in the 'patient' table
            $update_patient = $database->query(
                "UPDATE patient SET 
                    pemail='$email', 
                    pname='$name', 
                    ppassword='$password', 
                    pnic='$nic', 
                    ptel='$tele', 
                    pdob='$dob',
                    pdiagnosis='$diagnosis' 
                 WHERE pid='$id'"
            );

            // Update email in the 'webuser' table
            $update_webuser = $database->query(
                "UPDATE webuser SET email='$email' WHERE email='$oldemail'"
            );

            // Check if both updates were successful
            if ($update_patient && $update_webuser) {
                $error = '4'; // Success
            } else {
                $error = '5'; // Update failed
            }
        }
    } else {
        $error = '2'; // Password mismatch
    }
} else {
    $error = '3'; // Invalid request
}

// Redirect with the error message and ID
header("location: patient.php?action=edit&error=$error&id=$id");
exit();
?>

    
